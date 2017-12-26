<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../../../bootstrap.php';

use NFePHP\Common\Certificate;
use NFePHP\eSocial\Event;

$config     = [
    'tpAmb'          => 2,
    //tipo de ambiente 1 - Produção; 2 - Produção restrita - dados reais;3 - Produção restrita - dados fictícios.
    'verProc'        => '2_4_01',
    //Versão do processo de emissão do evento. Informar a versão do aplicativo emissor do evento.
    'eventoVersion'  => '2.4.1',
    //versão do layout do evento
    'serviceVersion' => '1.1.1',
    //versão do webservice
    'empregador'     => [
        'tpInsc'  => 1,  //1-CNPJ, 2-CPF
        'nrInsc'  => '99999999999999', //numero do documento
        'nmRazao' => 'Razao Social',
    ],
    'transmissor'    => [
        'tpInsc' => 1,  //1-CNPJ, 2-CPF
        'nrInsc' => '99999999999999' //numero do documento
    ],
];
$configJson = json_encode($config, JSON_PRETTY_PRINT);

//carrega os dados do envento
$std              = new \stdClass();
$std->sequencial  = 1;
$std->indapuracao = 1;
$std->perapur     = '2017-08';

$iderespinf           = new \stdClass();
$iderespinf->nmresp   = 'JOAO';
$iderespinf->cpfresp  = '11111111111';
$iderespinf->telefone = '1122223333';

$std->iderespinf = $iderespinf;

$infofech                  = new \stdClass();
$infofech->evtremun        = 'N';
$infofech->evtpgtos        = 'N';
$infofech->evtaqprod       = 'N';
$infofech->evtcomprod      = 'N';
$infofech->evtcontratavnp  = 'N';
$infofech->evtinfocomplper = 'N';

$std->infofech = $infofech;

try {
    //carrega a classe responsavel por lidar com os certificados
    $content     = file_get_contents('expired_certificate.pfx');
    $password    = 'associacao';
    $certificate = Certificate::readPfx($content, $password);

    //cria o evento e retorna o XML assinado
    $xml = Event::evtFechaEvPer(
        $configJson,
        $std,
        $certificate,
        '2017-08-03 10:37:00'
    )->toXml();

    header('Content-type: text/xml; charset=UTF-8');
    echo $xml;
} catch (\Exception $e) {
    echo $e->getMessage();
}
