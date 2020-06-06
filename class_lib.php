<?php

class crud
{
	private $db;
	
	function __construct($DB_con)
	{
		$this->db = $DB_con;
	}
	
	public function create($ci, $email, $nombre, $apellido, $pass, $telefono, $tipo_usuario)
	{
		try
		{
			$stmt = $this->db->prepare("INSERT INTO usuarios(ci,email,nombre,apellido,pass,telefono,tipo_usuario) VALUES(:ci, :email, :nombre, :apellido, :pass, :telefono, :tipo_usuario)");
			$stmt->bindparam(":ci",$ci);
			$stmt->bindparam(":email",$email);
			$stmt->bindparam(":nombre",$nombre);
			$stmt->bindparam(":apellido",$apellido);
			$stmt->bindparam(":pass",$pass);
			$stmt->bindparam(":telefono",$telefono);
			$stmt->bindparam(":tipo_usuario",$tipo_usuario);
			$stmt->execute();
			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
		
	}
	
	public function getUser($emailLogin)
	{
		$stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email=:email");
		$stmt->execute(array(":email"=>$emailLogin));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

	public function getCI($ci)
	{
		$stmt = $this->db->prepare("SELECT ci FROM usuarios WHERE ci=:ci");
		$stmt->execute(array(":ci"=>$ci));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

	public function getEmail($email)
	{
		$stmt = $this->db->prepare("SELECT email FROM usuarios WHERE email=:email");
		$stmt->execute(array(":email"=>$email));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
}

class ciudadesClass
{
	private $db;
	
	function __construct($DB_con)
	{
		$this->db = $DB_con;
	}

	public function getOrigenes()
	{
		$stmt = $this->db->prepare("SELECT DISTINCT id_origen FROM tiene_ciudad");
		$stmt->execute();
		$editRow=$stmt->fetchAll(PDO::FETCH_COLUMN);

		return $editRow;
	}

	public function getCiudades()
	{
		$result = array();

		$stmt = $this->db->prepare("SELECT * FROM ciudad");
		$stmt->execute();

		while ($editrow = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$result[$editrow['id']] = $editrow['nombre'];
		}

		return $result;
	}

	public function getDestinos($origen)
	{
		$stmt = $this->db->prepare("SELECT id_destino FROM tiene_ciudad WHERE id_origen=$origen");
		$stmt->execute();
		$editRow=$stmt->fetchAll(PDO::FETCH_COLUMN);

		return $editRow;
	}

	public function getIdOrigen($nomOrigen)
	{
		$stmt = $this->db->prepare("SELECT id FROM ciudad WHERE nombre=:nombre");
		$stmt->bindparam(":nombre",$nomOrigen);
		$stmt->execute();
		$editRow=$stmt->fetch(PDO::FETCH_COLUMN);
		return $editRow;
	}

	public function getAbreviacion($nomCiudad)
	{
		$stmt = $this->db->prepare("SELECT abreviacion FROM ciudad WHERE nombre=:nombre");
		$stmt->bindparam(":nombre",$nomCiudad);
		$stmt->execute();
		$editRow=$stmt->fetch(PDO::FETCH_COLUMN);
		return $editRow;
	}

	public function getNomCiudad($idCiudad)
	{
		$stmt = $this->db->prepare("SELECT nombre FROM ciudad WHERE id=:id");
		$stmt->bindparam(":id",$idCiudad);
		$stmt->execute();
		$editRow=$stmt->fetch(PDO::FETCH_COLUMN);
		return $editRow;
	}

	public function getHorario($origen, $destino, $dia){
		$stmt = $this->db->prepare("SELECT * FROM horario WHERE id_origen=:id_origen AND id_destino=:id_destino AND dia=:dia ORDER BY hora_sale");
		$stmt->execute(array(":id_origen"=>$origen,":id_destino"=>$destino, ":dia"=>$dia));
		$editRow=$stmt->fetchall(PDO::FETCH_ASSOC);
		return $editRow;
	}

	public function getHorarioByCod($codigo){
		$stmt = $this->db->prepare("SELECT * FROM horario WHERE codigo=:codigo");
		$stmt->execute(array(":codigo"=>$codigo));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

	public function getHorarioByDia($dia){
		$stmt = $this->db->prepare("SELECT * FROM horario WHERE dia=:dia");
		$stmt->execute(array(":dia"=>$dia));
		$editRow=$stmt->fetchall(PDO::FETCH_ASSOC);
		return $editRow;
	}

	public function getReserva($ci, $codigo, $fecha){
		$stmt = $this->db->prepare("SELECT * FROM reserva WHERE ci_usuario=:ci_usuario AND cod_horario=:cod_horario AND fecha_viaje=:fecha_viaje");
		$stmt->execute(array(":ci_usuario"=>$ci,":cod_horario"=>$codigo, ":fecha_viaje"=>$fecha));
		$editRow=$stmt->fetchall(PDO::FETCH_ASSOC);
		return $editRow;
	}

	public function getReservaByci($ci, $pago){
		$stmt = $this->db->prepare("SELECT * FROM reserva WHERE ci_usuario=:ci_usuario AND pago=:pago ORDER BY fecha_viaje");
		$stmt->execute(array(":ci_usuario"=>$ci, ":pago"=> $pago));
		$editRow=$stmt->fetchall(PDO::FETCH_ASSOC);
		return $editRow;
	}
	

	public function reservar($ci_usuario, $cod_horario, $fecha_viaje, $cant_asientos, $pago)
	{
		try
		{
			$stmt = $this->db->prepare("INSERT INTO reserva(ci_usuario,cod_horario,fecha_viaje,cant_asientos, pago) VALUES(:ci_usuario, :cod_horario, :fecha_viaje, :cant_asientos, :pago)");
			$stmt->bindparam(":ci_usuario",$ci_usuario);
			$stmt->bindparam(":cod_horario",$cod_horario);
			$stmt->bindparam(":fecha_viaje",$fecha_viaje);
			$stmt->bindparam(":cant_asientos",$cant_asientos);
			$stmt->bindparam(":pago",$pago);
			$stmt->execute();
			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
		
	}

	public function asientos($ci_usuario, $cod_horario, $fecha_viaje, $num_asiento)
	{
		try
		{
			$stmt = $this->db->prepare("INSERT INTO num_asientos(ci_usuario,cod_horario,fecha_viaje,num_asiento) VALUES(:ci_usuario, :cod_horario, :fecha_viaje, :num_asiento)");
			$stmt->bindparam(":ci_usuario",$ci_usuario);
			$stmt->bindparam(":cod_horario",$cod_horario);
			$stmt->bindparam(":fecha_viaje",$fecha_viaje);
			$stmt->bindparam(":num_asiento",$num_asiento);
			$stmt->execute();
			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
		
	}

	public function getCantAsientos($cod_horario, $fecha_viaje)
	{
		$stmt = $this->db->prepare("SELECT cant_asientos FROM reserva WHERE cod_horario='$cod_horario' AND fecha_viaje='$fecha_viaje'");
		$stmt->execute();
		$editRow=$stmt->fetchAll(PDO::FETCH_COLUMN);

		return $editRow;
	}

	public function getAsientosReservados($cod_horario, $fecha_viaje)
	{
		$stmt = $this->db->prepare("SELECT num_asiento FROM num_asientos WHERE cod_horario='$cod_horario' AND fecha_viaje='$fecha_viaje'");
		$stmt->execute();
		$editRow=$stmt->fetchAll(PDO::FETCH_COLUMN);

		return $editRow;
	}

	public function getciVendidos($cod_horario, $fecha_viaje)
	{
		$stmt = $this->db->prepare("SELECT ci_usuario FROM reserva WHERE pago='1' AND cod_horario='$cod_horario' AND fecha_viaje='$fecha_viaje'");
		$stmt->execute();
		$editRow=$stmt->fetchAll(PDO::FETCH_COLUMN);

		return $editRow;
	}

	public function getciMail($cod_horario, $fecha_viaje)
	{
		$stmt = $this->db->prepare("SELECT ci_usuario FROM reserva WHERE cod_horario='$cod_horario' AND fecha_viaje='$fecha_viaje'");
		$stmt->execute();
		$editRow=$stmt->fetchAll(PDO::FETCH_COLUMN);

		return $editRow;
	}

	public function getciCodigo($cod_horario)
	{
		$stmt = $this->db->prepare("SELECT ci_usuario FROM reserva WHERE cod_horario='$cod_horario'");
		$stmt->execute();
		$editRow=$stmt->fetchAll(PDO::FETCH_COLUMN);

		return $editRow;
	}

	public function getMail($cedula)
	{
		$stmt = $this->db->prepare("SELECT email FROM usuarios WHERE ci='$cedula'");
		$stmt->execute();
		$editRow=$stmt->fetch(PDO::FETCH_COLUMN);

		return $editRow;
	}

	public function getCancelado($cod_horario, $fecha_viaje)
	{
		$stmt = $this->db->prepare("SELECT cancelado FROM reserva WHERE cod_horario='$cod_horario' AND fecha_viaje='$fecha_viaje'");
		$stmt->execute();
		$editRow=$stmt->fetch(PDO::FETCH_COLUMN);

		return $editRow;
	}

	public function getAsientosVendidos($ci, $cod_horario, $fecha_viaje)
	{
		$stmt = $this->db->prepare("SELECT num_asiento FROM num_asientos WHERE ci_usuario='$ci' AND cod_horario='$cod_horario' AND fecha_viaje='$fecha_viaje'");
		$stmt->execute();
		$editRow=$stmt->fetchAll(PDO::FETCH_COLUMN);

		return $editRow;
	}

	public function updatePago($ci, $cod, $fecha, $pago)
	{
		try
		{
			$stmt=$this->db->prepare("UPDATE reserva SET pago=:pago WHERE ci_usuario=:ci_usuario AND cod_horario=:cod_horario AND fecha_viaje=:fecha_viaje");
			$stmt->bindparam(":pago",$pago);
			$stmt->bindparam(":ci_usuario",$ci);
			$stmt->bindparam(":cod_horario",$cod);
			$stmt->bindparam(":fecha_viaje",$fecha);
			$stmt->execute();
			
			return true;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}

	public function updateCancelado($cod_horario, $fecha_viaje, $cancelado)
	{
		try
		{
			$stmt=$this->db->prepare("UPDATE reserva SET cancelado=:cancelado WHERE cod_horario=:cod_horario AND fecha_viaje=:fecha_viaje");
			$stmt->bindparam(":cancelado",$cancelado);
			$stmt->bindparam(":cod_horario",$cod_horario);
			$stmt->bindparam(":fecha_viaje",$fecha_viaje);
			$stmt->execute();
			
			return true;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}

	public function insertCancel($ci_autoadmin, $cod_horario, $fecha_viaje, $cant_asientos)
	{
		try
		{
			$stmt = $this->db->prepare("INSERT IGNORE INTO reserva(ci_usuario,cod_horario,fecha_viaje,cant_asientos) VALUES(:ci_usuario, :cod_horario, :fecha_viaje, :cant_asientos)");
			$stmt->bindparam(":ci_usuario",$ci_autoadmin);
			$stmt->bindparam(":cod_horario",$cod_horario);
			$stmt->bindparam(":fecha_viaje",$fecha_viaje);
			$stmt->bindparam(":cant_asientos",$cant_asientos);
			$stmt->execute();
			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
		
	}

	public function getCiReserva($cod_horario, $fecha_viaje, $pago ){
		$stmt = $this->db->prepare("SELECT ci_usuario FROM reserva WHERE cod_horario='$cod_horario' AND fecha_viaje='$fecha_viaje' AND pago='$pago'");
		$stmt->execute();
		$editRow=$stmt->fetchAll(PDO::FETCH_COLUMN);

		return $editRow;
	}

	public function deleteAsientos($ci_usuario, $cod_horario, $fecha_viaje )
	{
		$stmt = $this->db->prepare("DELETE FROM num_asientos WHERE ci_usuario=:ci_usuario AND cod_horario=:cod_horario AND fecha_viaje=:fecha_viaje");
		$stmt->bindparam(":ci_usuario",$ci_usuario);
		$stmt->bindparam(":cod_horario",$cod_horario);
		$stmt->bindparam(":fecha_viaje",$fecha_viaje);
		$stmt->execute();
		return true;
	}

	public function deleteReserva($cod_horario, $fecha_viaje, $pago)
	{
		$stmt = $this->db->prepare("DELETE FROM reserva WHERE cod_horario=:cod_horario AND fecha_viaje=:fecha_viaje AND pago=:pago");
		$stmt->bindparam(":cod_horario",$cod_horario);
		$stmt->bindparam(":fecha_viaje",$fecha_viaje);
		$stmt->bindparam(":pago",$pago);
		$stmt->execute();
		return true;
	}
	
	public function insertViaje($dia, $hora_sale, $hora_llega, $precio, $id_origen, $id_destino)
	{
		try
		{
			$stmt = $this->db->prepare("INSERT INTO horario(dia,hora_sale,hora_llega,precio,id_origen,id_destino) VALUES(:dia, :hora_sale, :hora_llega, :precio, :id_origen, :id_destino)");
			$stmt->bindparam(":dia",$dia);
			$stmt->bindparam(":hora_sale",$hora_sale);
			$stmt->bindparam(":hora_llega",$hora_llega);
			$stmt->bindparam(":precio",$precio);
			$stmt->bindparam(":id_origen",$id_origen);
			$stmt->bindparam(":id_destino",$id_destino);
			$stmt->execute();
			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
		
	}

	public function updateViaje($codigo, $salida, $llegada)
	{
		try
		{
			$stmt=$this->db->prepare("UPDATE horario SET hora_sale=:salida, hora_llega=:llegada WHERE codigo=:codigo");
			$stmt->bindparam(":salida",$salida);
			$stmt->bindparam(":llegada",$llegada);
			$stmt->bindparam(":codigo",$codigo);
			$stmt->execute();
			
			return true;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}
}
?>

	

	

