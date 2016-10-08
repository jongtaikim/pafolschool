<?
	class Oracle
	{
		var $DBID = "EZFLV";
		var $DBPW = "FLV0673";
		var $DBSID = "ewut";
        var  $conn;
		var $stmt;
		
		var $error = false;					// ���� �߻��ϸ� true �� ������. commit,rollback ������ ���
		var $transaction = false;			// true �� auto commit ����

		var $bind = array();
		var $data_size = array();

		// php4 �� ������
		function Oracle(){	
			
			$this->connect();
		}
		// php5 �� ������
		function __construct(){	
			
			$this->connect();
		}
		// php5 �� �Ҹ���
		function __destruct(){	
			
			$this->disConnect();
		}

		function connect(){

			if(!$this->conn)
				$this->conn = OCILogon($this->DBID,$this->DBPW,$this->DBSID);
		}
		
		function disConnect(){

			if($this->stmt)
				@@OCIFreeStatement($this->stmt);
			if($this->conn)
				@@OCILogoff($this->conn);
		}
		// ���ε庯�� �� ����
		// ���� ���̶� executeDML() ȣ������ �ݵ�� �Ź� ȣ���ؾ� ��(executeDML() �Լ�ȣ���� �ʱ�ȭ�ǹǷ�)
		function setBind($bind){

			if(is_array($bind))
				$this->bind = $bind;
			else if($bind)
				$this->bind = array($bind);
		}
		// ���ε庯�� ������ ����. �������ϸ� �ش纯���� �ִ����� �⺻����
		function setDataSize($data_size){

			if(is_array($data_size))
				$this->data_size = $data_size;
			else if($data_size)
				$this->data_size = array($data_size);
		}

		// ������ ����� '���߹迭($rs[�ʵ��][�ε���])'�� �����Ѵ�
		// $preferch_size�� ������ ���ڵ�Ǽ��� ������(�ɼ�)
		function selectList($query,$preferch_size=1){
			
			$this->connect();
			$this->stmt = OCIparse($this->conn,$query);

			if($this->stmt){
				$this->bindByName();														
				$this->prefetch($preferch_size);										

				if($this->transaction){						
					@@OCIexecute($this->stmt,OCI_DEFAULT);
					$this->error();
				}else{
					@@OCIexecute($this->stmt);
				}
				$rows = @@OCIFetchStatement($this->stmt,$rs);				
	
				if($rows){					
					if(!$this->transaction)
						@@OCIFreeStatement($this->stmt);
					return $rs;
				}
			}			
			return array();
		}
		// ������ ��� 1���� '�迭($rs[�ʵ�� or �ε���])'�� �����Ѵ�
		// $option �� OCI_ASSOC(�ʵ��) or OCI_NUM(�ε���) �� ����(�ɼ�)
		function selectRow($query,$option=OCI_ASSOC){
			
			$this->connect();
			$this->stmt = OCIparse($this->conn,$query);

			if($this->stmt){

				$this->bindByName();

				if($this->transaction){						
					@@OCIexecute($this->stmt,OCI_DEFAULT);
					$this->error();
				}else{
					@@OCIexecute($this->stmt);
				}
				if(@@OCIFetchInto($this->stmt,$rs,$option+OCI_RETURN_NULLS)){
					if(!$this->transaction)
						@@OCIFreeStatement($this->stmt);
					return $rs;
				}					
			}			
			return array();
		}
		// �Ѱ� ���� �����ϴ� �������� ó���Ѵ� 
		//	ROWID,LOB,FILE �� �ܿ��� ��Ʈ������ ��ȯ�Ѵ�
		function selectOne($query){

			$this->connect();
			$this->stmt = OCIparse($this->conn,$query);		

			if($this->stmt){

				$this->bindByName();

				if($this->transaction){						
					@@OCIexecute($this->stmt,OCI_DEFAULT);
					$this->error();
				}else{
					@@OCIexecute($this->stmt);
				}
				if(@@OCIFetch($this->stmt)){

					// �μ� 1�� �÷����� �ε���(1���� �����Կ� ����!,�÷��� ������ ����)
					$value = @@OCIResult($this->stmt,1);	
					if(!$this->transaction)
						@@OCIFreeStatement($this->stmt);
					return $value;
				}
			}
		}
		// insert,update,delete ���� ������ ������� �ο��� ������ �����Ѵ�(auto commit �� ��츸 ������ ������)
		// $transaction=true �� ��� �������� �ݵ�� commit() �Լ��� ȣ���Ѵ�
		function executeDML($sql){

			$this->connect();
			$this->stmt = OCIparse($this->conn,$sql);	
			
			if($this->stmt){
				$this->bindByName();

				if($this->transaction){							// auto commit �� �ƴ� ���
					@@OCIexecute($this->stmt,OCI_DEFAULT);			
//					$num = @@OCIRowCount($this->stmt);			// error() �Լ��� �۵�����!
					$this->error();
				}else{
					@@OCIexecute($this->stmt);
					$num = @@OCIRowCount($this->stmt);
					@@OCIFreeStatement($this->stmt);
					
					return $num;					
				}
			}
		}
		// auto commit ���ϰ� ��������� transaction ����
		// executeDML() ȣ���� �������� �ݵ�� commit() �Լ��� ȣ���Ѵ�
		function transaction(){

			$this->transaction = true;
		}
		// transaction �Ϸ��� commit �̸� true�� ������
		// executeDML() ���� ������ �ϳ��� �߻��ϸ� �ڵ� rollback ��
		function commit(){

			if(!$this->error){
				@@OCICommit($this->conn);
				$commit = true;
			}else{
				@@OCIRollback($this->conn);
				$commit = false;
			}
			if($this->stmt)
				@@OCIFreeStatement($this->stmt);

			$this->transaction = false;
			$this->error = false;

			return $commit;
		}
		// $transaction=true �� ��� �Ź� executeDML ���� �ڵ�ȣ��ȴ�
		// ���� �߻��� ��� rollback�� �Ǵܱ����� $error ���� ����
		function error(){

			if($error = @@OCIError($this->stmt)){				
//				echo "<p> Error is : " . $error["code"] . " - " . $error["message"] . "<p>";
				$this->error = true;
			}
		}
		// :b1,:b2,:b3...�� ���ε� ���� ����
		// ���ε庯������ �ݵ�� :b1,:b2,:b3... ���� �����Ѵ�
		function bindByName(){

			$size = sizeof($this->bind);

			for($i=0 ; $i < $size ; $i++){

				$ds = $this->data_size[$i];
				if(!$ds) $ds = -1;

				@@OCIBindByName($this->stmt,":b".($i+1),$this->bind[$i],$ds);
			}
			$this->bind = array();														
			$this->data_size = array();
		}
		// ����Ŭ Ŭ���̾�Ʈ ���ۿ� ����Ǵ� ���ڵ��� ���� ����
		// ���� ���ڵ带 select�� ��� ����Ʈ ���� ��ȿ�����̹Ƿ� ������ �Ǽ���ŭ ����
		function prefetch($preferch_size){

			if($preferch_size > 1)
				@@OCISetPrefetch($this->stmt,$preferch_size);
		}
	}
?>

