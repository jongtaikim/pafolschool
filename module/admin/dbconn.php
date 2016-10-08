<?
	class Oracle
	{
		var $DBID = "EZFLV";
		var $DBPW = "FLV0673";
		var $DBSID = "ewut";
        var  $conn;
		var $stmt;
		
		var $error = false;					// 에러 발생하면 true 로 수정됨. commit,rollback 결정에 사용
		var $transaction = false;			// true 면 auto commit 않함

		var $bind = array();
		var $data_size = array();

		// php4 의 생성자
		function Oracle(){	
			
			$this->connect();
		}
		// php5 의 생성자
		function __construct(){	
			
			$this->connect();
		}
		// php5 의 소멸자
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
		// 바인드변수 값 지정
		// 같은 값이라도 executeDML() 호출전에 반드시 매번 호출해야 함(executeDML() 함수호출후 초기화되므로)
		function setBind($bind){

			if(is_array($bind))
				$this->bind = $bind;
			else if($bind)
				$this->bind = array($bind);
		}
		// 바인드변수 사이즈 지정. 지정안하면 해당변수의 최대사이즈가 기본값임
		function setDataSize($data_size){

			if(is_array($data_size))
				$this->data_size = $data_size;
			else if($data_size)
				$this->data_size = array($data_size);
		}

		// 쿼리문 결과를 '다중배열($rs[필드명][인덱스])'로 리턴한다
		// $preferch_size는 가져올 레코드건수를 지정함(옵션)
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
		// 쿼리문 결과 1건을 '배열($rs[필드명 or 인덱스])'로 리턴한다
		// $option 은 OCI_ASSOC(필드명) or OCI_NUM(인덱스) 을 지정(옵션)
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
		// 한개 값만 리턴하는 쿼리문을 처리한다 
		//	ROWID,LOB,FILE 등 외에는 스트링으로 반환한다
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

					// 인수 1은 컬럼순서 인덱스(1부터 시작함에 주의!,컬럼명 지정도 가능)
					$value = @@OCIResult($this->stmt,1);	
					if(!$this->transaction)
						@@OCIFreeStatement($this->stmt);
					return $value;
				}
			}
		}
		// insert,update,delete 등을 실행후 영향받은 로우의 갯수를 리턴한다(auto commit 일 경우만 갯수를 리턴함)
		// $transaction=true 일 경우 마지막에 반드시 commit() 함수를 호출한다
		function executeDML($sql){

			$this->connect();
			$this->stmt = OCIparse($this->conn,$sql);	
			
			if($this->stmt){
				$this->bindByName();

				if($this->transaction){							// auto commit 이 아닐 경우
					@@OCIexecute($this->stmt,OCI_DEFAULT);			
//					$num = @@OCIRowCount($this->stmt);			// error() 함수가 작동안함!
					$this->error();
				}else{
					@@OCIexecute($this->stmt);
					$num = @@OCIRowCount($this->stmt);
					@@OCIFreeStatement($this->stmt);
					
					return $num;					
				}
			}
		}
		// auto commit 않하고 명시적으로 transaction 시작
		// executeDML() 호출후 마지막에 반드시 commit() 함수를 호출한다
		function transaction(){

			$this->transaction = true;
		}
		// transaction 완료후 commit 이면 true를 리턴함
		// executeDML() 에서 에러가 하나라도 발생하면 자동 rollback 됨
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
		// $transaction=true 일 경우 매번 executeDML 에서 자동호출된다
		// 에러 발생할 경우 rollback의 판단기준인 $error 값을 변경
		function error(){

			if($error = @@OCIError($this->stmt)){				
//				echo "<p> Error is : " . $error["code"] . " - " . $error["message"] . "<p>";
				$this->error = true;
			}
		}
		// :b1,:b2,:b3...에 바인드 변수 지정
		// 바인드변수명은 반드시 :b1,:b2,:b3... 으로 지정한다
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
		// 오라클 클라이언트 버퍼에 저장되는 레코드의 수를 지정
		// 여러 레코드를 select할 경우 디폴트 값인 비효율적이므로 가져올 건수만큼 지정
		function prefetch($preferch_size){

			if($preferch_size > 1)
				@@OCISetPrefetch($this->stmt,$preferch_size);
		}
	}
?>

