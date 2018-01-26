$( document ).ready(function() {
                    var $server,$wtexto;
                    //$server = 'http://localhost:4343/xampp/registro/www/';
                    //$server = 'http://www.infrasoftarquivos.com.br/arquivos';
                    //$server = 'http://www.infrasoftarquivos.com.br/conn_danieltel';
                    $server = 'http://www.infrasoftarquivos.com.br/conn_speedline';
                    //$server = 'http://www.infrasystem.inf.br/danieltel';   //  /conectadanieltel';  nao aceitou nenhum destes 2 locais
                    var $login,senha,data,wtexto ;
             
                     $('#entrar').on('click', function(){
                        $login = $('#login').val();     
                        $senha = $('#senha').val(); 
                        $wtexto = "login="+$login+"&senha="+$senha+"&acao=loginusuario" ;
                        $.ajax({
                            type: "get",   
                            dataType:"html",
                            url: $server+"/conecta.php",
                            data: $wtexto,
                            error: function(data) {
                                alert("Erro na conexao");
                            },
                            success: function(data) {
                                $volta = $('#listarusuario').html(data);
                                if (data=="S"){
                                   window.location.href = '#pagina2';    
                                }else{
                                    alert("LOGIN ou SENHA ERRADA");
                                    //alert("LOGIN:erro 2"+data);
                                }
                            }
                        });
                         $wtexto = ""

                     });
         
    
    
                     $('#versaldo').on('click', function(){
                        $login = $('#login').val();     
                        $wtexto = "login="+$login+"&acao=versaldo" ;
                        $.ajax({     
                            type: "get",
                            url: $server+"/conecta.php",
                            data: $wtexto,
                            success: function(data) {
                                   window.location.href = '#paginaversaldo';
                                   $('#listagemsaldo').html(data);
                            }
                        });
                        $wtexto = ""   

                     });
    
                     $('#darbaixa').on('click', function(){
                        $login = $('#login').val();     
                        $wtexto = "login="+$login+"&acao=darbaixa" ;      
                        $.ajax({     
                            type: "get",      
                            url: $server+"/conecta.php",   
                            data: $wtexto,
                            success: function(data) {
                                   window.location.href = '#paginadarbaixa';   
                                   $('#vaidarbaixa').html(data);
                            }
                        });
                        $wtexto = ""           
       
                     });       
   
       
                     $('#gerardarbaixa').on('click', function(){
                        $login      = $('#login').val();     
                        $numerodaos = $('#numerodaos').val();     
                        $idabaixar  = $('#idabaixar').val();     
                        $qtdabaixar = $('#qtdabaixar').val();     
                        $wtexto     = "login="+$login+"&numerodaos="+$numerodaos+"&idabaixar="+$idabaixar+"&qtdabaixar="+$qtdabaixar+"&acao=gerardarbaixa" ;
                        $.ajax({     
                            type: "get",
                            url: $server+"/conecta.php",
                            data: $wtexto,
                            success: function(data) {
                                   $numerodaos = $('#numerodaos').val("");     
                                   $idabaixar  = $('#idabaixar').val("");     
                                   $qtdabaixar = $('#qtdabaixar').val("");     
                                   window.location.href = '#paginaresultado';
                                    $('#listarresultado').html(data);
                            }
                        });
                        $wtexto = ""

                     });

    
    
            });

   
      