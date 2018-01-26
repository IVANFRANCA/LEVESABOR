<?php
//include("config.php");
$servidor = 'www.infrasystem.inf.br';
$usuario  = 'speedline2017';
$senha    = 'willine2017@';   
$banco    = 'speedline';
// Conecta-se ao banco de dados MySQL
$mysqli = new mysqli($servidor, $usuario, $senha, $banco);
// Caso algo tenha dado errado, exibe uma mensagem de erro
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

//-------------------------------------------------------------------------------------------------------------------------

//Login usuario
if($_GET['acao'] == 'loginusuario'){
    $login = $_GET['login'];
    $senha = $_GET['senha'];
    $sql = "SELECT login,pswd
            FROM sec_estoquefuncusers 
            WHERE login  = '$login' ";
    $re = $mysqli->query($sql);
     $num = mysqli_num_rows($re);

     if($num > 0){
         while ($linha = mysqli_fetch_array($re)) {
             $wvolta = $linha["pswd"];
         }
         $wmd5senha = md5($senha) ;
         
         if ( $wmd5senha == $wvolta){
           $wresultado =  "S" ;  //.$wmd5senha."----".$wvolta;
         }else{
              $wresultado = "N";
         }
      }
      else{
         $wresultado = "N";
      }
    
$mysqli->close();
echo $wresultado;
 
//JSON encoding
//echo json_encode(array(
//        "success" => $success,
//        "msg" => $msg
//));  
}

//-------------------------------------------------------------------------------------------------------------------------

//Dar baixa
if($_GET['acao'] == 'darbaixa'){
    $login   = $_GET['login'];
    $codfunc = '00000';

    $sql = "SELECT login,CODIGO
            FROM sec_estoquefuncusers 
            WHERE login  = '$login' ";
    $re  = $mysqli->query($sql);
    $num = mysqli_num_rows($re);

     if($num > 0){
         while ($linha = mysqli_fetch_array($re)) {
             $codfunc = $linha["CODIGO"];
         }
      }
    echo "<b>Login:</b>".$login." <b>Cod.func.</b>".$codfunc."<br><HR><br>";
//-------------------------------------->
    //$sql   = "SELECT idsequencia,CODIGO,QTD,QTDBX
    //          FROM notaitem 
    //           WHERE CODFUNC = '$codfunc' AND TIPO = 'S'
    //          AND QTD > QTDBX
    //          ORDER BY idsequencia DESC";
    
    $sql   = "SELECT nota.idsequencia,nota.CODIGO,nota.QTD,nota.QTDBX,
                     est.CODIGO,est.TIPOPROD
              FROM   notaitem nota
              inner  join estoque est
              on     nota.CODIGO = est.CODIGO
              WHERE nota.CODFUNC = '$codfunc' 
              AND nota.TIPO = 'S'
              AND est.TIPOPROD = 'P'
              AND nota.QTD > nota.QTDBX
              ORDER BY nota.idsequencia DESC";
    
     $re  = $mysqli->query($sql);
     $num = mysqli_num_rows($re);

     if($num > 0){
           while($Linha = mysqli_fetch_object($re)){
                  $zqtd   = $Linha->QTD; 
                  $zqtdbx = $Linha->QTDBX;
                  $wsoma  = $zqtd-$zqtdbx;
               
                $sql = "SELECT CODIGO,DESCRICAO FROM estoque WHERE CODIGO = '$Linha->CODIGO'"; 
                $aprod = $mysqli->query($sql);
                while ($produtos = mysqli_fetch_array($aprod)) {
                       $nomeprod = $produtos["DESCRICAO"];
                }
                echo "<b>Prod:</b>".$Linha->CODIGO."-".$nomeprod."<br>";
                echo "<b>ID:</b>".          $Linha->idsequencia.
                     "<b> <--> Saldo:</b>". $wsoma   ."</br><hr><hr><hr><hr><hr>";
               $nomeprod = "";
           }
      }
      else{
          echo 'NENHUM ESTOQUE DISPONIVEL!';
      }
      
$mysqli->close();

}


//-------------------------------------------------------------------------------------------------------------------------

//ver saldo
if($_GET['acao'] == 'versaldo'){
    $login   = $_GET['login'];
    $codfunc = '00000';

    $sql = "SELECT login,CODIGO
            FROM sec_estoquefuncusers 
            WHERE login  = '$login' ";
    $re  = $mysqli->query($sql);
    $num = mysqli_num_rows($re);

     if($num > 0){
         while ($linha = mysqli_fetch_array($re)) {
             $codfunc = $linha["CODIGO"];
         }
      }
    echo "<b>Login:</b>".$login." <b>Cod.func.</b>".$codfunc."<br><HR><br>";
//-------------------------------------->
    //$sql   = "SELECT idsequencia,CODIGO,QTD,QTDBX
    //          FROM notaitem 
    //          WHERE CODFUNC = '$codfunc' AND TIPO = 'S'
    //          AND QTD > QTDBX
    //          ORDER BY idsequencia DESC";
    $sql   = "SELECT nota.idsequencia,nota.CODIGO,nota.QTD,nota.QTDBX,
                     est.CODIGO,est.TIPOPROD
              FROM   notaitem nota
              inner  join estoque est
              on     nota.CODIGO = est.CODIGO
              WHERE nota.CODFUNC = '$codfunc' 
              AND nota.TIPO = 'S'
              AND est.TIPOPROD = 'P'
              AND nota.QTD > nota.QTDBX
              ORDER BY nota.idsequencia DESC";
    
     $re  = $mysqli->query($sql);
     $num = mysqli_num_rows($re);

     if($num > 0){
           while($Linha = mysqli_fetch_object($re)){
                  $zqtd   = $Linha->QTD; 
                  $zqtdbx = $Linha->QTDBX;
                  $wsoma  = $zqtd-$zqtdbx;
               
				//echo "<li id='idseq-".$Linha->idsequencia."'>" .
                //     "<b>ID:</b>".           $Linha->idsequencia. 
                //     "<b> <--> Codigo:</b>". $Linha->CODIGO.   
                //     "<b> <--> Saldo:</b> ".$wsoma."</br><hr>".
                //     "<a class='editable' data-split-theme='c'>".
				//     " </a><a href='#' data-icon='delete' class='close' data-theme='c'>x</a></li>";
 
                $sql = "SELECT CODIGO,DESCRICAO FROM estoque WHERE CODIGO = '$Linha->CODIGO'"; 
                $aprod = $mysqli->query($sql);
                while ($produtos = mysqli_fetch_array($aprod)) {
                       $nomeprod = $produtos["DESCRICAO"];
                }
                echo "<b>Prod:</b>".$Linha->CODIGO."-".$nomeprod."<br>";
                echo "<b>ID:</b>".          $Linha->idsequencia.
                     "<b> <--> Saldo:</b>". $wsoma   ."</br><hr>";
               $nomeprod = "";
           }
      }
      else{
          echo 'NENHUM ESTOQUE DISPONIVEL!';
      }
$mysqli->close();

}



//-------------------------------------------------------------------------------------------------------------------------

//Gerar DAR BAIXA
if($_GET['acao'] == 'gerardarbaixa'){
    
    $login      = $_GET['login'];
    $xnumeroos = $_GET['numerodaos'];   
    $idabaixar  = $_GET['idabaixar'];
    $qtdabaixar = $_GET['qtdabaixar'];
    $wcodfunc   = '00000';

    $sql = "SELECT login,CODIGO
            FROM sec_estoquefuncusers 
            WHERE login  = '$login' ";
    $re  = $mysqli->query($sql);
    $num = mysqli_num_rows($re);

     if($num > 0){
         while ($linha = mysqli_fetch_array($re)) {
             $wcodfunc = $linha["CODIGO"];
         }
      }
    echo "<b>Login:</b>".$login." <b>Cod.func.</b>".$wcodfunc."<br><HR><br>";
//-------------------------------------->
    $sql   = "SELECT idsequencia,QTD,QTDBX,CODFUNC,DATAMOV,NUMERO,CODIGO,VALOR
              FROM notaitem 
              WHERE idsequencia = '$idabaixar'";
              
    $re  = $mysqli->query($sql);
    $num = mysqli_num_rows($re);

    if($num > 0){
        while($Linha = mysqli_fetch_object($re)){  
                  if ($Linha->CODFUNC == $wcodfunc){
                     $xdatamov   = $Linha->DATAMOV;  
                     //$xnumeroos  = $Linha->NUMERO;  
                     $xcodfunc   = $Linha->CODFUNC;   
                     $xcodprod   = $Linha->CODIGO;     
                     $xvalorunit = $Linha->VALOR;     
                         
                     $zqtd       = $Linha->QTD; 
                     $zqtdbx     = $Linha->QTDBX;
                     $wsoma      = $zqtd-$zqtdbx;
                     if ($wsoma<1){
                         echo "ID JA FOI BAIXADO, NAO E POSSIVEL BAIXAR DE NOVO";
                     }else{
                        if ($qtdabaixar>$wsoma){
                            echo "QUANTIDADE MAIOR QUE O SALDO DISPONIVEL PARA BAIXAR";
                        }else{
                           $wtotal = $zqtdbx + $qtdabaixar;
                           $bsql   = "UPDATE notaitem SET QTDBX='$wtotal' WHERE idsequencia='$idabaixar'"; 
                           //$zprod  = $mysqli->query($bsql);
                           $zalt   = mysqli_query($mysqli,$bsql);
                           //$num    = mysqli_num_rows($mysqli) ; 
                           $num    = mysqli_affected_rows($mysqli);
                           if($num > 0){
                               //echo date('Ymd');
                               $xvaltotal = $qtdabaixar*$xvalorunit ;
                               $bsql      = "INSERT INTO notaitemdetalhe (DATAMOV,NUMERO,CODFUNC,CODIGO,CONTROLE,TIPO,QTDBX,VALOR,VALTOTAL,LOJAORIG,LOJADESTINO) 
                                                VALUES ('$xdatamov','$xnumeroos','$xcodfunc','$xcodprod','$idabaixar','B','$qtdabaixar','$xvalorunit','$xvaltotal','','')"; 
                               $zins   = mysqli_query($mysqli,$bsql);
                               $num    = mysqli_affected_rows($mysqli);
                               if($num > 0){
                                  echo "PRODUTO BAIXADO DO ESTQOUE";
                               }else{
                                  echo "PROBLEMA INCLUSAO DA BAIXA DO PRODUTO";  
                               }
                            
                           }else{
                              echo "PROBLEMA NA BAIXA DO PRODUTO";  
                           }
                        }
                     }
                  }else{
                      echo "ID NAO PERTENTE AO FUNCIONARIO";
                  }
                      
           }
    }else{
          echo 'ID NAO LOCALIZADA!!!';   
    }
$mysqli->close();



}




?>