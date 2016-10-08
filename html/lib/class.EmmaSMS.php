<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: class.EmmaSMS.php
* 작성일: 2006-01-10
* 작성자: 이범민
* 설  명: EMMA SMS(for Oracle) Class
  주의사항 : SMS 발송 실패시 Oracle DB에서 RollBack 하고 에러로그를 기록 함
*****************************************************************
* 
*/
define('EMMASMS_ERR_INVALID_MOBILE','01');
define('EMMASMS_ERR_INVALID_PHONE','02');
define('EMMASMS_ERR_INVALID_MESSAGE','03');
define('EMMASMS_ERR_INVALID_DATE','04');
define('EMMASMS_ERR_DB','05');
define('EMMASMS_SEND_OK','00');

class EmmaSMS
{
    var $db;
    var $insert_sql;
    var $error = array();

    function EmmaSMS ()
    {
        $this->db = &WebApp::singleton('DB');
    }

    /*
        자동메시지 발송
        실패시 에러로그 저장(BS_SMS_ERROR)
        $sect = memj | memw | ordc | ordo | payo | sndc | ccrq | ccco | rego
    */
    function send_auto ($sect, $re_phone, $userid = '', $username = '', $onum = '')
    {
        $argdump = var_export(array(
            'sect'      => $sect,
            're_phone'  => $re_phone,
            'userid'    => $userid,
            'username'  => $username,
            'onum'      => $onum
        ), true);
        if (!ereg('^(memj|memw|ordc|ordo|payo|sndc|ccrq|ccco|back)$',$sect)) {
            return $this->_error_log('SMSAUTO_INVALID_SECT', $argdump);
        }
        if (!$re_phone = $this->_format_mobile($re_phone)) {
            return $this->_error_log('SMSAUTO_INVALID_MOBILE', $argdump);
        }
        if (!$se_phone = $this->_format_phone(_OPHONE)) {
            return $this->_error_log('SMSAUTO_INVALID_PHONE', $argdump, _OPHONE);
        }
        $sql = "SELECT 
num_use_".$sect."_m,
num_use_".$sect."_a,
num_use_".$sect."_b,
str_msg_".$sect."_m,
str_msg_".$sect."_a,
str_msg_".$sect."_b
FROM BS_SMS_ORGAN WHERE num_oid="._OID;
        if (!$data = $this->db->sqlFetch($sql)) {
            return $this->_error_log('SMSAUTO_FAILED_SQL', $argdump, $sql);
        }

        $data['str_msg_'.$sect.'_m'] = $this->_format_auto_msg($data['str_msg_'.$sect.'_m'], $userid, $username, $onum);
        $data['str_msg_'.$sect.'_a'] = $this->_format_auto_msg($data['str_msg_'.$sect.'_a'], $userid, $username, $onum);
        $data['str_msg_'.$sect.'_b'] = $this->_format_auto_msg($data['str_msg_'.$sect.'_b'], $userid, $username, $onum);

        $sql = "SELECT
                    /*+ INDEX_DESC (BS_SMS_SEND_LOG PK_BS_SMS_SEND_LOG) */
                    num_serial FROM BS_SMS_SEND_LOG WHERE num_oid="._OID." AND rownum=1";
        $serial = $this->db->sqlFetchOne($sql) + 1;

        $count = 0;
        if ($data['num_use_'.$sect.'_m'] && $data['str_msg_'.$sect.'_m']) {
            $result_code = $this->_insert_msg(
                $re_phone,
                $se_phone,
                $data['str_msg_'.$sect.'_m'],
                _OID,
                $serial,
                date('Y-m-d H:i:s')
            );
            if($result_code !== EMMASMS_SEND_OK) {
                return $this->_error_log('SMSAUTO_FAILED_INSERT_MSG', $argdump, $this->insert_sql);
            }
            $count++;
        }
        if ($data['num_use_'.$sect.'_a'] && $data['str_msg_'.$sect.'_a']) {
            $master_mobile = WebApp::getConf('master_mobile');
            if($master_mobile = $this->_format_mobile($master_mobile)) {
                $result_code = $this->_insert_msg(
                    $master_mobile,
                    $se_phone,
                    $data['str_msg_'.$sect.'_a'],
                    _OID,
                    $serial,
                    date('Y-m-d H:i:s')
                );
                if($result_code !== EMMASMS_SEND_OK) {
                    return $this->_error_log('SMSAUTO_FAILED_INSERT_MSG', $argdump, $this->insert_sql);
                }
                $count++;
            }
        }
        if ($data['num_use_'.$sect.'_b'] && $data['str_msg_'.$sect.'_b']) {
            $sql = "SELECT str_mobile FROM ".BS_STAFF." WHERE num_oid=$_OID";
            if ($list = $this->db->sqlFetchAll($sql)) {
                foreach($list as $row) {
                    $result_code = $this->_insert_msg(
                        $this->_format_mobile($row['str_mobile']),
                        $se_phone,
                        $data['str_msg_'.$sect.'_b'],
                        _OID,
                        $serial,
                        date('Y-m-d H:i:s')
                    );
                    if($result_code !== EMMASMS_SEND_OK) {
                        return $this->_error_log('SMSAUTO_FAILED_INSERT_MSG', $argdump, $this->insert_sql);
                    }
                    $count++;
                }
            }
        }

        if (!$count) return false;
        $sql = "INSERT INTO BS_SMS_SEND_LOG (
num_oid,num_serial,str_se_phone,str_msg,num_point,str_part,dt_date,dt_sdate
) VALUES (
"._OID.",$serial,'$se_phone','".$data['str_msg_'.$sect.'_m']."',$count,'자동발송',SYSDATE,SYSDATE
)";
        if (!$this->db->query($sql)) {
            return $this->_error_log('SMSAUTO_FAILED_SEND_LOG', $argdump, $sql);
        }
        $sql = "UPDATE BS_SMS_ORGAN SET
NUM_POINT = NUM_POINT - $count,
NUM_USE_POINT = NUM_USE_POINT + $count
WHERE num_oid="._OID;
        if (!$this->db->query($sql)) {
            return $this->_error_log('SMSAUTO_FAILED_UPDATE_POINT', $argdump, $sql);
        }
        $this->db->commit();
    }

    // 일반 SMS 보내기
    function send ($re_phones, $se_phone, $msg, $oid = 0, $part = '일반발송', $date = '')
    {
        if (!$se_phone = $this->_format_phone($se_phone))   return EMMASMS_ERR_INVALID_PHONE;
        if (!$msg = $this->_cut_str($msg))                  return EMMASMS_ERR_INVALID_MESSAGE;
        if ($date == '') $date = date('Y-m-d H:i:s');
        if (!$this->date = $this->_validate_date($date))    return EMMASMS_ERR_INVALID_DATE;
        if (!is_array($re_phones)) $re_phones = array($re_phones);
        for ($i = 0, $count = count($re_phones); $i < $count; $i++) {
            if (!$re_phones[$i] = $this->_format_mobile($re_phones[$i])) {
                return EMMASMS_ERR_INVALID_MOBILE;
            }
        }

        $sql = "SELECT
                    /*+ INDEX_DESC (BS_SMS_SEND_LOG PK_BS_SMS_SEND_LOG) */
                    num_serial FROM BS_SMS_SEND_LOG WHERE num_oid=$oid AND rownum=1";
        $serial = $this->db->sqlFetchOne($sql) + 1;
        $sql = "INSERT INTO BS_SMS_SEND_LOG (
num_oid,num_serial,str_se_phone,str_msg,num_point,str_part,dt_date,dt_sdate
) VALUES (
$oid,$serial,'$se_phone','$msg',$count,'$part',SYSDATE,TO_DATE('$date','YYYY-MM-DD HH24:MI:SS')
)";
        if (!$this->db->query($sql)) return EMMASMS_ERR_DB;
        foreach ($re_phones as $re_phone) {
            $result_code = $this->_insert_msg($re_phone, $se_phone, $msg, $oid, $serial, $date);
            if ($result_code !== EMMASMS_SEND_OK) {
                return $result_code;
            }
        }

        $sql = "UPDATE BS_SMS_ORGAN SET
NUM_POINT = NUM_POINT - $count,
NUM_USE_POINT = NUM_USE_POINT + $count
WHERE num_oid=$oid";
        if (!$this->db->query($sql)) return EMMASMS_ERR_DB;
        $this->db->commit();

        return EMMASMS_SEND_OK;
    }

    function _insert_msg ($re_phone, $se_phone, $msg, $oid, $serial, $date)
    {
        $this->insert_sql = "INSERT INTO EM_TRAN (
tran_oid,tran_serial,tran_pr,tran_phone,tran_callback,tran_status,tran_date,tran_msg
) VALUES (
$oid,$serial,em_tran_pr.nextval,'".$re_phone."','".$se_phone."',1,TO_DATE('".$date."','YYYY-MM-DD HH24:MI:SS'),'".$msg."'
)";
        if (!$this->db->query($this->insert_sql)) return EMMASMS_ERR_DB;
        return EMMASMS_SEND_OK;
    }

    function _format_mobile ($mobile)
    {
        if (!ereg('^(010|011|016|017|018|019)-?([0-9]{3,4})-?([0-9]{4})$',$mobile,$result)) return false;
        return $result[1].'-'.$result[2].'-'.$result[3];
    }
    function _format_phone ($phone)
    {
        if (!ereg('(0[0-9]{1,2})(-|\.|_| )?([0-9]{3,4})(-|\.|_| )?([0-9]{4})',$phone,$result)) return false;
        return $result[1].'-'.$result[3].'-'.$result[5];
    }
    function _format_auto_msg ($msg, $userid, $username, $onum) {
        $msg = str_replace(
                    array('{USERID}','{USERNAME}','{ORDERNUM}'),
                    array($userid, $username, $onum),
                    $msg);
        return $this->_cut_str($msg);
    }
    function _validate_date ($date = '')
    {
        return ereg('^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$',$date);
    }

    function _cut_str ($str,$len = 255,$tail = "")
    {
        if (strlen($str) > $len) {
            for ($i = 0; $i<$len; $i++) if (ord($str[$i]) > 127) $i++;
            if ($i > $len) $i -= 2;
            $str = substr($str,0,$i).$tail;
        }
        return $str;
    }

    function _error_log ($code, $argdump, $msg = '') {
        $this->db->rollback();

        $msg = addslashes($msg);
        $argdump = addslashes($argdump);

        $sql = "SELECT /*+ INDEX_DESC (".BS_SMS_ERR_LOG." ".PK_BS_SMS_ERR_LOG.") */ num_serial FROM ".BS_SMS_ERR_LOG." WHERE num_oid="._OID." AND ROWNUM=1";
        $serial = $this->db->sqlFetchOne($sql) + 1;

        $sql = "INSERT INTO ".BS_SMS_ERR_LOG." (
                    num_oid, num_serial, str_code, str_argdump, str_err_msg, dt_date
                ) VALUES (
                    "._OID.", $serial, '$code', '$argdump', '$msg', SYSDATE
                )";
        $this->db->query($sql);
        $this->db->commit();
        return false;
    }
}
?>