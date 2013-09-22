<?php
/** 
 * @author Williams Mendez
 * @example	$calendario = new Calendario();
		$eventos = array(5=>array(
								   array(
								   			'evento'=>'Feria',
								   			'descripcion'=>"Descripcion de la Feria"
								   		),
								   	array(
								   			'evento'=>'Examen',
								   			'descripcion'=>'Descripcion de nuestro Examen'
								   		)
								   ),
						 12=>array(
						 			array(
						 					'evento'=>'Entrega de Reportes',
						 					'descripcion'=>'Se describe la entrega de reportes'
						 				)
						 		  )
						);
		$this->view->calendario = $calendario->getCalendario($eventos); 
 * 
 *
 */
class Calendario {
	
	/**
	 * Metodo que calcula el calendario para
	 * un determinado mes de cualquier año.
	 *
	 * @param array	$eventos
	 * @param string $date	 
	 * @return string
	 */
	public function getCalendarioCausa($eventos) {
		
		
	$HTML ='';	
	$cuenta=0;
	$n=count( $eventos );
	$mescont =0;
	$meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	
	while ( $cuenta < $n ) {   
	    $row = &$eventos[$cuenta];
	    $fecha= explode ( '-',$row->fecha);

		$month = $fecha [1];
		$year = $fecha [0];
		$mesActual = intval($fecha [1]);
		
		$fila =0;
		$filas=5;
				if (! $this->esBisiesto ( $year )) {
					if ($month == 2) {
						$d = getdate ( strtotime ( $year . '-2-1' ) );
						if ($d ['wday'] == 0) {
							$filas --;
						}
					}
				}
		

		$primerDiaMes = $this->getPrimerDia ( $year, $month );
		$HTML .= '<table class="table table-bordered"> 
					<tr class="warning">
						<td align="center"><b>'.$meses[$mesActual].'</b></td>
					</tr>
					<table class="table table-bordered">
						<tr class="success">
						<td><b>D</b></td>
						<td><b>L</b></td>
						<td><b>M</b></td>
						<td><b>M</b></td>
						<td><b>J</b></td>
						<td><b>V</b></td>
						<td><b>S</b></td>
					</tr>
					';
		$CantDias = $this->getDaysInMonth ( $month, $year );
		
		$DiaActual = 1;
						
					while ( $fila < $filas ) {
													
						$HTML .= '<tr>';
						for($i = 0; $i < 7; $i ++) {
							
									if (($fila == 0 && $i < $primerDiaMes) || ($DiaActual > $CantDias)) {
										$HTML .= '<td></td>';
									} else {
										
										if ($DiaActual == $fecha [2] ) {
											$HTML .= '
											<td style="width:25px; height:25px;">
												<div class="icon-48-amarillo">
													<span style="color:red;">'.$DiaActual.'</span>
												</div>
											</td>';
										} 
										
										else {
											$HTML .= '
											<td style="width:25px; height:25px;">
											<div><span>'.$DiaActual.'</span></div>
											</td>';
										}
										$DiaActual ++;
									}
							
							}	

						$HTML .= '</tr>';
						$fila ++;
					}	

			$HTML .= '</table>';
		$cuenta ++;
		}
		return $HTML;
	}
	
	public function getCalendario($eventos, $date = null) {
		if (is_null ( $date )) {
			$fecha = explode ( '-', date ( 'Y-m-d' ) );
		} else {
			$fecha = explode ( '-', $date );
		}
		$month = $fecha [1];
		$year = $fecha [0];
		
		$fila = 0;
		$filas = 5;
		if (! $this->esBisiesto ( $year )) {
			if ($month == 2) {
				$d = getdate ( strtotime ( $year . '-2-1' ) );
				if ($d ['wday'] == 0) {
					$filas --;
				}
			}
		}
		
		$primerDiaMes = $this->getPrimerDia ( $year, $month );
		
		$HTML = '<table class="table table-bordered"> <thead><tr class="warning">
						<th><b>D</b></th>
						<th><b>L</b></th>
						<th><b>M</b></th>
						<th><b>M</b></th>
						<th><b>J</b></th>
						<th><b>V</b></th>
						<th><b>S</b></th>
					<thead></tr>';
		$CantDias = $this->getDaysInMonth ( $month, $year );
		$DiaActual = 1;

		while ( $fila < $filas ) {
			$HTML .= '<tr>';
			for($i = 0; $i < 7; $i ++) {
				if (($fila == 0 && $i < $primerDiaMes) || ($DiaActual > $CantDias)) {
					$HTML .= '<td></td>';
				} else {
					if ($DiaActual == $fecha [2]) {
						$HTML .= $this->setDia ( $DiaActual, isset ( $eventos [$DiaActual] ) ? $eventos [$DiaActual] : null, true );
						//$HTML .= '<td><span style="color:red;">'.$DiaActual.'</span></td>';
					} else {
						$HTML .= $this->setDia ( $DiaActual, isset ( $eventos [$DiaActual] ) ? $eventos [$DiaActual] : null );
						//$HTML .= '<td>'.$DiaActual.'</td>';
					}
					$DiaActual ++;
				}
			}
			$HTML .= '</tr>';
			$fila ++;
		}
		
		return $HTML . '</table>';
	
	}
	/**
	 * Le da formato a un cada dia en el calendario,
	 * tomando en cuenta si hay algun evente para 
	 * el dia en cuestion
	 *
	 * @param Integer $dia
	 * @param array $eventos
	 * @param bool $esHoy
	 * @return string
	 */
	public function setDia($dia, $eventos, $esHoy = false) {
		$ev1 = '';
		$ev2 = '';
		$existeEvento = False ;
		if ($esHoy) {
			$estiloEventos = 'color:red';
			$estiloDia = 'background:#F79F81';
		} else {
			$estiloEventos = '';
			$estiloDia = 'background:#CEE3F6';
		}
		if (! is_null ( $eventos )) {
			foreach ( $eventos as $evento ) {
				//$ev .= "<div><span style='$estiloEventos' title='{$evento['motivo']}'>{$evento['motivo']}</span></div>";
				//print_r ($evento['diaactual']); 
				if ($evento['diaactual']== $dia ){
					$existeEvento= true ; 
					$ev2 .= "<span class='editlinktip hasTip' title='Tooltip title::This is the tooltip text' >$dia</span>";
					//$ev2 .= "</span><div> ";//<span style='$estiloEventos' title='{$evento['motivo']}'>{$evento['motivo']}</span></div>";
				    }
			}
		}
		if ($existeEvento){
		$ev1 .= "<div>.$ev1.$dia</span></div>";	
		}else{
			$ev1 .= "<div>$dia</div>";
		}
		 	

				
		$html = "<td style='$estiloDia; width:25px; height:25px; font-weight:bold;' >$ev1</td>";
		
		return $html;
	
	}
	
	/**
	 * Busca que dia de la semana cae el primer dia de un mes
	 * de cualquier año en formato numerico, esto es, un numero
	 * del 0-6, siendo Domingo el dia 0 y sabado el dia 6
	 *
	 * @param Integer $year
	 * @param Integer $month
	 * @return Integer
	 */
	public function getPrimerDia($year, $month) {
		$d = getdate ( strtotime ( $year . '-' . $month . '-1' ) );
		return $d ['wday'];
	}
	/**
	 * Calcular los dias que tiene cualquier mes, cualquier año 
	 */
	public function getDaysInMonth($month, $year) {
		$days = null;
		if ($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12)
			$days = 31;
		elseif ($month == 4 || $month == 6 || $month == 9 || $month == 11)
			$days = 30;
		else if ($month == 2) {
			if ($this->esBisiesto ( $year ))
				$days = 29;
			else
				$days = 28;
		}
		return $days;
	}
	/**
	 * Calcula si el año es bisiesto
	 *
	 * @param Integer $Year
	 * @return boolean
	 */
	public function esBisiesto($Year) {
		if ((($Year % 4) == 0) && (($Year % 100) != 0) || (($Year % 400) == 0))
			return true;
		else
			return false;
	}

}
?>
