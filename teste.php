<?php
    /*
     * Definição do padrão de projeto bridge desacoplando injeções de dependencias
    */
    interface APIDesenho {
        
        public function desenharCirculo(int $x, int $y, int $radius);
        
    }
    
    class APIDesenho1 implements APIDesenho {
        
        public function desenharCirculo(int $x, int $y, int $radius) {
            
            echo "<p><strong>Versão 1</strong>"."<br>".PHP_EOL;
            echo "<p>Coordenada x: ".$x."</p>";
            echo "<p>Coordenada y: ".$y."</p>";
            echo "<p>Radius: ".$radius."</p>";
            
        }
        
    }
    
    class APIDesenho2 implements APIDesenho {
        
        public function desenharCirculo(int $x, int $y, int $radius) {
            
            echo "<p>Versão 2</strong>"."<br>".PHP_EOL;
            
            if(!empty($x) and !empty($y) and !empty($radius)) {
               
                echo "valores recebidos"."<br>".PHP_EOL;
                
                if($x > $y) {
                    
                    for ($i = 1; $i <= $radius; $i++) {
                        
                        echo "Número => ".$i."<br>".PHP_EOL;
                        
                    }
                    
                }else {
                    
                    echo "<p>Opa valor de x não é maior que y</p>";
                    
                }
                
            }else {
                   
                header("Location: index.php");
                exit();
                
            }
            
        }
        
    }
    
    //define classe abstrata Forma recebendo injeção de dependencia variada
    abstract class Forma {
        
        protected object $api;
        protected int $x;
        protected int $y;
        
        public function __construct(APIDesenho $api) {
            
            if(isset($api) and !empty($api) and is_object($api)) {
                   
                $this->api = $api;
                
            }
            
        }
        
    }
    
    //definição da class Circulo herdando Forma 
    class Circulo extends Forma {
        
        protected int $radios;
        
        public function __construct(int $x, int $y, int $radius, APIDesenho $api) {
                
            parent::__construct($api); //referencia construtor da classe Pai forma já definido passando objeto
            $this->x = intval($x);
            $this->y = intval($y);
            $this->radios = intval($radius);
            
        }
        
        public function desenharCirculo() {
            
            $this->api->desenharCirculo($this->x, $this->y, $this->radios);
            
        }
        
    }
    
    //instancia(objeto) da class Circulo
    $circulo = new Circulo(5, 3, 9, new APIDesenho2());
    $circulo->desenharCirculo();
?>
