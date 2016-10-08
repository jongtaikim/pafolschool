<?

/***************************************
  GD ���̺귯�� �̿� ��ư Ŭ����
  ������ 2007-12-14
 ***************************************/

 class EZBtn { 
    //��ȯ�� ���� ���� 
    var $Files = null; 
    //�̹��� ���� 
    var $Imgs = array(); 
    //��ȯ�� �̹��� ���� 
    var $Config = array(); 
    var $IsSave = false; 
    var $UseUTF8 = false; 

    //���� �̹��� ��� 
    var $Path = "Img"; 
    //��ȯ ���� 
    var $Mode = "4C";        //4C, 2W, 2H 
    //���� ��Ʈ 
    var $UseFont = "/fonts/yg330.ttf"; 

    //�������� �߶� ����� ������ (�ȼ�) 
    var $CutSize = 8; 

    //�̹��� ������ ����ϴ�. 
    function SetImg($Files) { 
        $this->Files = $Files; 

		$this->Imgs = array(); 
        if(is_array($Files)) foreach($Files as $No=>$Name) $this->Imgs[$No] = $this->GetImgInfo($Name); 
        else $this->Imgs = $this->GetImgInfo($Files); 
    } 
    //�̹��� ������ ���մϴ�. 
    function GetImgInfo($FileName) { 
        $ImgInfo['Name'] = $FileName; 
        $ImgInfo['File'] = $this->GetNameExt($FileName); 
      
	
	  	list($ImgInfo['Width'], $ImgInfo['Height'], $ImgInfo['Type'], $ImgInfo['Attr']) = getimagesize($FileName); 
       
		return $ImgInfo; 
    } 
    //���ϸ�� Ȯ���ڸ� �и��մϴ�. 
    function GetNameExt($FileName) { 
        preg_match('/(.*)\.([^\.]+)$/', $FileName, $Match); 
        $File['name'] = $Match[1]; 
        $File['ext'] = strtolower($Match[2]); 
        return $File; 
    } 
    //������ �����մϴ�. 
    function MakeBtnImg($Files, $Text='') { 
        $this->SetImg($Files); 
       
	$_func = sprintf("CreateButton_%s", $this->Mode);

        if(method_exists($this, $_func)) { 
         
			if(is_array($this->Files)) { 
            
				foreach($this->Imgs as $Img) { 
                    $Im = $this->GetImg($Img); 
                    if($Im) { 
                        if($this->IsSave) $this->SaveImg($Img, $this->$_func($Img, $Im), 'result'); 
                        else $this->ImgView($Img, $this->$_func($Img, $Im)); 
                    } 
                } 
            } 
            else { 
               
				$Im = $this->GetImg($this->Imgs); 
//////
                if($Im) { 
                    $SaveIm = $this->$_func($this->Imgs, $Im); 
                    if($Text) $SaveIm = $this->SetText($SaveIm, $Text); 
                    if($this->IsSave) $this->SaveImg($this->Imgs, $SaveIm, 'result'); 
                    else $this->ImgView($this->Imgs, $SaveIm); 
                } 
            } 
        } 
    } 
    //16���� color�� RGB���·� ��ȯ�Ѵ�. 
    function HEX2RGB($Color) { 
        $String = str_replace("#","",$Color); 
        $RGB[] = hexdec(substr($String,0,2));        //red 
        $RGB[] = hexdec(substr($String,2,2));        //green 
        $RGB[] = hexdec(substr($String,4,2));        //blue 
        return $RGB; 
    } 
    //�������� ���ڸ� �����ϴ�. 
    function SetText($Im, $Text) { 
        if($this->UseUTF8) $Text = iconv("EUC-KR", "UTF-8", $Text); 
        $size = ($this->Config['FontSize'])?$this->Config['FontSize']:16; 
        $top = ($this->Config['FontTop'])?$this->Config['FontTop']:25; 
        $left = ($this->Config['FontLeft'])?$this->Config['FontLeft']:10; 
        //���� ���� 
        $angle = ($this->Config['FontAngle'])?$this->Config['FontAngle']:0; 
        $color = ($this->Config['FontColor'])?$this->HEX2RGB($this->Config['FontColor']):array(60, 60, 60); 
        $TextColor = imagecolorallocate($Im, $color[0], $color[1], $color[2]); 
        imagettftext($Im, $size, $angle, $left, $top, $TextColor, $this->UseFont, $Text); 
        return $Im; 
    } 
    //�������� ���� �̹����� �����մϴ�. 
    function GetImg($Img) { 
//print_r($Img);
		if($Img['Type']<1 && $Img['Type'] > 3) 	return false; 
	
        if($Img['Type']==1){ 
			
		$Im = imagecreatefromgif($Img['Name']); 
		
		}else if($Img['Type']==2){ 
		 $Im = imagecreatefromjpeg($Img['Name']); 
        
		}elseif($Img['Type']==3){ 
			 $Im = imagecreatefrompng($Img['Name']); 
        }
		return $Im; 
    } 
    //���� �̹��� 4���� �����̸� �߶� �������� ����ϴ�. 
    function CreateButton_4C($Img, $Im) { 
        $Width = ($this->Config['BtnWidth'])?$this->Config['BtnWidth']:$Img['Width']; 
        $Height = ($this->Config['BtnHeight'])?$this->Config['BtnHeight']:$Img['Height']; 
        $SaveIm = imagecreatetruecolor($Width, $Height); 

        $PosWidth = $Img['Width']-$this->CutSize; 
        $PosHeight = $Img['Height']-$this->CutSize; 
        $PosWidth2 = $Img['Width']-$this->CutSize*2; 
        $PosHeight2 = $Img['Height']-$this->CutSize*2; 

        $RePosWidth = $Width-$this->CutSize; 
        $RePosHeight = $Height-$this->CutSize; 
        $RePosWidth2 = $Width-$this->CutSize*2; 
        $RePosHeight2 = $Height-$this->CutSize*2; 

        //1 
        imagecopy($SaveIm, $Im, 0, 0, 0, 0, $this->CutSize, $this->CutSize); 
        //2 
        imagecopy($SaveIm, $Im, $RePosWidth, 0, $PosWidth, 0, $this->CutSize, $this->CutSize); 
        //3 
        imagecopy($SaveIm, $Im, 0, $RePosHeight, 0, $PosHeight, $this->CutSize, $this->CutSize); 
        //4 
        imagecopy($SaveIm, $Im, $RePosWidth, $RePosHeight, $PosWidth, $PosHeight, $this->CutSize, $this->CutSize); 
        //��ܰ�� 
        imagecopyresampled($SaveIm, $Im, $this->CutSize, 0, $this->CutSize, 0, $RePosWidth2, $this->CutSize, $this->CutSize, $this->CutSize); 
        //�ϴܰ�� 
        imagecopyresampled($SaveIm, $Im, $this->CutSize, $RePosHeight, $this->CutSize, $PosHeight, $RePosWidth2, $this->CutSize, $this->CutSize, $this->CutSize); 
        //���ʰ�� 
        imagecopyresampled($SaveIm, $Im, 0, $this->CutSize, 0, $this->CutSize, $this->CutSize, $RePosHeight2, $this->CutSize, $this->CutSize); 
        //�����ʰ�� 
        imagecopyresampled($SaveIm, $Im, $RePosWidth, $this->CutSize, $PosWidth, $this->CutSize, $this->CutSize, $RePosHeight2, $this->CutSize, $this->CutSize); 
        //��� 
        imagecopyresampled($SaveIm, $Im, $this->CutSize, $this->CutSize, $this->CutSize, $this->CutSize, $RePosWidth2, $RePosHeight2, $this->CutSize, $this->CutSize); 
        imagedestroy($Im); 
        return $SaveIm ; 
    } 
    //���� �̹��� �¿������ �߶� �������� ����ϴ�. 
    function CreateButton_2W($Img, $Im) { 
        $Width = ($this->Config['BtnWidth'])?$this->Config['BtnWidth']:$Img['Width']; 
        $Height = $Img['Height']; 
        $SaveIm = imagecreatetruecolor($Width, $Height); 

        $PosWidth = $Img['Width']-$this->CutSize; 
        $PosHeight = $Img['Height']-$this->CutSize; 
        $PosWidth2 = $Img['Width']-$this->CutSize*2; 
        $PosHeight2 = $Img['Height']-$this->CutSize*2; 

        $RePosWidth = $Width-$this->CutSize; 
        $RePosHeight = $Height-$this->CutSize; 
        $RePosWidth2 = $Width-$this->CutSize*2; 
        $RePosHeight2 = $Height-$this->CutSize*2; 

        //���� 
        imagecopy($SaveIm, $Im, 0, 0, 0, 0, $this->CutSize, $Img['Height']); 
        //������ 
        imagecopy($SaveIm, $Im, $RePosWidth, 0, $PosWidth, 0, $this->CutSize, $Img['Height']); 
        //��� 
        imagecopyresampled($SaveIm, $Im, $this->CutSize, 0, $this->CutSize, 0, $RePosWidth2, $Img['Height'], $this->CutSize, $Img['Height']); 
        imagedestroy($Im); 
        return $SaveIm ; 
    } 
    //���� �̹��� ���Ͼ����� �߶� �������� ����ϴ�. 
    function CreateButton_2H($Img, $Im) { 
        $Width = $Img['Width']; 
        $Height = ($this->Config['BtnHeight'])?$this->Config['BtnHeight']:$Img['Height']; 
        $SaveIm = imagecreatetruecolor($Width, $Height); 

        $PosWidth = $Img['Width']-$this->CutSize; 
        $PosHeight = $Img['Height']-$this->CutSize; 
        $PosWidth2 = $Img['Width']-$this->CutSize*2; 
        $PosHeight2 = $Img['Height']-$this->CutSize*2; 

        $RePosWidth = $Width-$this->CutSize; 
        $RePosHeight = $Height-$this->CutSize; 
        $RePosWidth2 = $Width-$this->CutSize*2; 
        $RePosHeight2 = $Height-$this->CutSize*2; 

        //��� 
        imagecopy($SaveIm, $Im, 0, 0, 0, 0, $Img['Width'], $this->CutSize); 
        //�ϴ� 
        imagecopy($SaveIm, $Im, 0, $RePosHeight, 0, $PosHeight, $Img['Width'], $this->CutSize); 
        //��� 
        imagecopyresampled($SaveIm, $Im, 0, $this->CutSize, 0, $this->CutSize, $Img['Width'], $RePosHeight2, $Img['Width'], $this->CutSize); 
        imagedestroy($Im); 
        return $SaveIm; 
    } 
    //���� �̹����� �����մϴ�. 
    function SaveImg($Img, $SaveIm, $Status) { 
        $SaveFileName = sprintf("%s/%s_%s.%s", $this->Path, $Img['File']['name'], $Status, $Img['File']['ext']); 
      	if($Img['Type']==1) imagegif($SaveIm, $SaveFileName); 
        else if($Img['Type']==2) imagejpeg($SaveIm, $SaveFileName, 100); 
        else if($Img['Type']==3) imagepng($SaveIm, $SaveFileName); 
        // �޸𸮿� �ִ� �׸� ���� 
        imagedestroy($SaveIm); 
    } 
    //resource �� ��� �̹����� ���ϴ�. 
    function ImgView($Img, $SaveIm) { 
        if($Img['Type']==1) imagegif($SaveIm); 
        else if($Img['Type']==2) imagejpeg($SaveIm, 100); 
        else if($Img['Type']==3) imagepng($SaveIm); 
        // �޸𸮿� �ִ� �׸� ���� 
        imagedestroy($SaveIm); 
    } 
    //����� �̹����� ���ϴ�. 
    function SaveImgView($FileName) { 
        
		$NameExt = $this->GetNameExt($FileName); 
        $FileSize = filesize($FileName); 
        if(eregi("(MSIE 5.5|MSIE 6.0|MSIE 7.0)", $_SERVER['HTTP_USER_AGENT'])) { // ������ ���� 
            Header("Content-Transfer-Encoding: binary"); 
        } else { 
            Header("Content-Description: PHP3 Generated Data"); 
        } 
        Header(sprintf("Content-Type: %s", $NameExt['ext'])); 
        Header(sprintf("Content-Disposition: attachment; filename=%s", $FileName)); 
        Header(sprintf("Content-Length: %s", $FileSize)); 
        Header("Pragma: no-cache"); 
        Header("Expires: 0"); 
        $fp = fopen($FileName, "r"); 
        if(!fpassthru($fp)) fclose($fp); 
    } 
} 



//�̰� ���� ���ߵ��� ���� ����̴�.
//������ ������ �ʿ��ϽǶ� �����̳ʿ��� ��Ź���� ���� �ٷ� ����� ����^^

//�̹��� ������ �迭�� �����Ѱ� ���� ������ �Ѳ����� ��ȯ �Ϸ��� ������
//���������� �����Ұ�� ������������ ������ ��� ���� ��
//�뷫 ����

//make mibany 2007 12 08


$_CEZBtn = new EZBtn();


//form ������ �Ѿ�� �ѱ��ΰ�� �����⶧���� true �����Ѵ�
$_CEZBtn->UseUTF8 = true;

//����ɼ� ����Ҷ� (�� �ɼ��� ����ϸ� "������/Img/�̸�_result.Ȯ����")
//��, [����] Img ������ �̸� �����ϰ� 777 ������ ����Ѵ�.
//$_CEZBtn->IsSave = true;
//�����θ� �����Ҷ� ���( �ݵ�� �ش� ������ �ְ� 777 ������ ����Ѵ�.)
//$_CEZBtn->Path = "./Img/";

//��ȯ��带 �����Ҷ� ���
	// '4C' (�̹��� 4���� �����̸� �߶� ������ ���� ����)
	// '2W' (�¿� ������ �߶� ������ ���� ����)
	// '2H' (���� ������ �߶� ������ ���� ����)
$_CEZBtn->Mode = "4C";

//�⺻ ��Ʈ�� �����Ҷ� ��� ttf ��Ʈ�� ������ ���ε� �ϰ� �ش��θ� �����ϸ�
//�ش� ��Ʈ�� ����� ���ڸ� ������ �ִ�.
$_CEZBtn->UseFont = "../../fonts/yg330.ttf";

//�ڸ� �̹��� ũ�⸦ �����Ѵ�.(4�𼭸� �Ǵ� ����, ���ϸ� �ڸ� �ȼ�ũ��)
$_CEZBtn->CutSize = 8;
if(!$color) $color = "838383";
if(!$top) $top = 12;
//���ڸ� �Է��Ҷ� ũ��� ���� �̹��� ���� ������ ��ġ ���� (angle �� ���� ����)
$_CEZBtn->Config = array(
	'BtnWidth'=>$w,		//���� �����ȼ�
	'BtnHeight'=>$h,		//���� �����ȼ�
	'FontSize'=>8,		//��Ʈ ������
	'FontTop'=>20,			//��Ʈ ��ܿ���
	'FontLeft'=>10,		//��Ʈ ���ʿ���
	'FontAngle'=>0,		//��Ʈ ����
	'FontColor'=>$color,		//��Ʈ ��
);

$_CEZBtn->MakeBtnImg($bg,$text);	


if($_CEZBtn->IsSave) {
	$_CEZBtn->SaveImgView('./Img/btn_result22.gif');
}



?>