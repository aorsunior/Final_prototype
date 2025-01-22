<?php

class connect
{

    function conn() //ฟังก์ชันที่เชื่อมต่อกับ Database ทั้งหมด
    {
        $host = 'localhost';
        $dbname = 'abcd';
        $user = 'root';
        $pass = '';
        $conn = new PDO ("mysql:host=$host;dbname=$dbname","$user","$pass");
        $conn->exec("set names utf8");
        return $conn;
    }


    function query($sql)  //ฟังก์ชันที่เกี่ยวกับการ execute
    {
        $conn = $this->conn(); //เรียกใช้ฟังก์ชันใน class
        $res = $conn->prepare($sql);
        $res->execute();
        return $res;
    }

    function counts($res)  //ฟังก์ชันที่เกี่ยวกับการ execute
    {
        $counts = $res->rowCount();
        return $counts;
    }

    function save_logs($action,$uid)
	{
		$sql = "insert into `logs` set `action` = '".$action."', `uid` = '".$uid."', `date` = '".time()."'";
		$this->query($sql);
	}

	function salter($txt)
	{
		$key = 'Bluekoff';
		$txt = md5($key.":".$txt.":".$key);
		return $txt;
	}

	function query_lastid($sql)
	{
        $conn = $this->conn(); //เรียกใช้ฟังก์ชันใน class
        $res = $conn->prepare($sql);
        $res->execute();
        return $conn->lastInsertId();
	}

	function check_acl()
	{
		if (isset($_REQUEST['option']))
		{
			$option = $_REQUEST['option'];
		}
		else
		{
			$option = "logs";
		}
		$sql = "select max(`acl`.`accl`) as `mca` from `app`, `acl`, `uig` where `app`.`dir` = '".$option."' and `acl`.`status` = '1' and `uig`.`status` = '1' and `acl`.`appid` = `app`.`id` and `acl`.`ugid` = `uig`.`ugid` and `uig`.`uid` = '".$_SESSION['uid']."'";
		$res = $this->query($sql);
		while ($cdr = $res->fetch())
		{
			$acl = $cdr['mca'];
		}
		
		return $acl;
	}

	function get_app_group($id)
	{
		if ($id == 1)
		{
			$res = "Back End";
		}
		elseif ($id == 2)
		{
			$res = "Accounting";
		}
		elseif ($id == 3)
		{
			$res = "Purchasing";
		}
		elseif ($id == 4)
		{
			$res = "Warehouse";
		}
		elseif ($id == 5)
		{
			$res = "Production";
		}
		elseif ($id == 6)
		{
			$res = "Sale";
		}
		elseif ($id == 7)
		{
			$res = "HR";
		}
		elseif ($id == 8)
		{
			$res = "Farming";
		}
		return $res;
	}

	function get_app_control($id)
	{
		if ($id == 0)
		{
			$res = "No Access";
		}
		elseif ($id == 1)
		{
			$res = "Read";
		}
		elseif ($id == 2)
		{
			$res = "Write";
		}
		elseif ($id == 3)
		{
			$res = "Read + Write";
		}
		elseif ($id == 4)
		{
			$res = "Approve";
		}
		elseif ($id == 5)
		{
			$res = "Read + Approve";
		}
		elseif ($id == 6)
		{
			$res = "Write + Approve";
		}
		elseif ($id == 7)
		{
			$res = "Full Access";
		}
		return $res;
	}

	function get_acc_typ($id)
	{
		if ($id == 1)
		{
			$res = "สินทรัพย์";
		}
		elseif ($id == 2)
		{
			$res = "หนี้สิน";
		}
		elseif ($id == 3)
		{
			$res = "ทุน";
		}
		elseif ($id == 4)
		{
			$res = "รายได้";
		}
		elseif ($id == 5)
		{
			$res = "ค่าใช้จ่าย";
		}
		return $res;
	}

	function get_status($id)
	{
		if ($id == 0)
		{
			$res = "In-Active";
		}
		elseif ($id == 1)
		{
			$res = "Active";
		}
		elseif ($id == 2)
		{
			$res = "Approve";
		}
		return $res;
	}

	function get_doc_code() 
	{
		return "doc";
		
	}

	function get_user_name() 
	{
		return "user_name";
	}

}

?>