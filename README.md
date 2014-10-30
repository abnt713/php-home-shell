Home Shell
==========

Home management and control using REST

### Requisitos ###

Para executar este projeto, você vai precisar de:
* Um servidor Apache2 com:
  * Suporte a PHP 5
  * Suporte a SQLite 3

> Nota: Verifique as permissões do arquivo '/application/database/homeshell.db', uma vez que estamos falando sobre SQLite!
  

*(Opcional)*: Você pode querer também uma lâmpada de teste. Acesse [Lamp Strut Simulator](http://github.com/alisonbento/lamp-strut-simulator) e pegue a sua!

Tendo esses requisitos, você já pode passar para a "instalação"

### Instalação ###

Clone (ou baixe) este repositório e coloque a pasta home-shell em algum lugar visível no seu servidor.

Abra o arquivo '/application/config/config.php' e modifique a constante **SERVER_ADDR** para o endereço correspondente no seu servidor (SEM O PREFIXO "HTTP://" ou "HTTPS://")

(Opcional) Abra o arquivo '/application/config/hs.php' e modifique a constante **HOMESHELL_LOCALE** para a abreviação do seu idioma (verifique quais os idiomas disponíveis na pasta '/locale/')

No mais, você está pronto para usar o sistema!

### Comandos ###

Neste sistema, os métodos HTTP utilizados foram:
* GET - Para leitura de dados e obtenção de informações
* POST - INSERT e UPDATE de dados
* DELETE - Remoção de dados

Todas as requisições necessitam de um TOKEN para que sejam processadas corretamente. O TOKEN possui um período de validade que é renovado a cada nova requisição válida.

* / - [GET] Mostra informações sobre o sistema em execução
* /appliances - [GET] Retorna todas as appliances cadastradas no sistema
  * /appliances/*n* - [GET] Retorna as informações da appliance com o ID *n*
    * /appliances/*n*/services - [GET] Retorna os serviços relativos a appliance de ID *n*
      * /appliances/*n*/services/service_name - [POST] executa o serviço **service_name** na appliance de ID *n*
    * /appliances/*n*/status - [GET] retorna os status da appliance de ID *n*
* /session - 
  * [GET] Verifica se existe uma sessão ativa; 
  * [POST] Abre uma sessão segundo parâmetros *username* e *password* passados na requisição, retornando um TOKEN
  * [DELETE] Realiza o logout (coming soon)
  
