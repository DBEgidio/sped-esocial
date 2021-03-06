<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../../../bootstrap.php';

use JsonSchema\Constraints\Constraint;
use JsonSchema\Constraints\Factory;
use JsonSchema\SchemaStorage;
use JsonSchema\Validator;

$evento  = 'evtCAT';
$version = '02_03_00';

$jsonSchema = '{
    "title": "evtCAT",
    "type": "object",
    "properties": {
        "sequencial": {
            "required": true,
            "type": "integer",
            "minimum": 1,
            "maximum": 99999
        },
        "indretif": {
            "required": true,
            "type": "integer",
            "minimum": 1,
            "maximum": 2
        },
        "nrrecibo": {
            "required": false,
            "type": ["string","null"],
            "maxLength": 40
        },
        "tpregistrador": {
            "required": true,
            "type": "integer",
            "minimum": 1,
            "maximum": 9
        },
        "tpinsc": {
            "required": true,
            "type": "integer",
            "minimum": 1,
            "maximum": 2
        },
        "nrinsc": {
            "required": true,
            "type": "string",
            "maxLength": 15
        },
        "cpfTrab": {
            "required": true,
            "type": "string",
            "maxLength": 11
        },
        "nisTrab": {
            "required": false,
            "type": ["string","null"],
            "maxLength": 11
        },
        "cat": {
            "required": true,
            "type": "object",
            "properties": {
                "dtacid": {
                    "required": true,
                    "type": "string",
                    "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                },
                "tpacid": {
                    "required": true,
                    "type": "string",
                    "minLength": 6,
                    "maxLength": 6
                },
                "hracid": {
                    "required": true,
                    "type": "string",
                    "pattern": "^(?:2[0-3]|[0-1]?[0-9])[0-5]?[0-9]$"
                },
                "hrstrabantesacid": {
                    "required": true,
                    "type": "string",
                    "pattern": "^(?:2[0-3]|[0-1]?[0-9])[0-5]?[0-9]$"
                },
                "tpcat": {
                    "required": true,
                    "type": "integer",
                    "minimum": 1,
                    "maximum": 3
                },
                "indcatobito": {
                    "required": true,
                    "type": "string",
                    "pattern": "S|N"
                },
                "dtobito": {
                    "required": false,
                    "type": ["string","null"],
                    "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                },
                "indcomunpolicia": {
                    "required": true,
                    "type": "string",
                    "pattern": "S|N"
                },
                "codsitgeradora": {
                    "required": false,
                    "type": ["string","null"],
                    "maxLength": 9,
                    "pattern": "^[0-9]"
                },
                "iniciatcat": {
                    "required": true,
                    "type": "integer",
                    "minimum": 1,
                    "maximum": 3
                },
                "observacao": {
                    "required": false,
                    "type": ["string","null"],
                    "maxLength": 255
                },
                "localacidente": {
                    "required": true,
                    "type": "object",
                    "properties": {
                        "tplocal": {
                            "required": true,
                            "type": "integer",
                            "minimum": 1,
                            "maximum": 9
                        },
                        "dsclocal": {
                            "required": false,
                            "type": ["string","null"],
                            "maxLength": 80
                        },
                        "dsclograd": {
                            "required": false,
                            "type": ["string","null"],
                            "maxLength": 80
                        },
                        "nrlograd": {
                            "required": false,
                            "type": ["string","null"],
                            "maxLength": 10
                        },
                        "codmunic": {
                            "required": false,
                            "type": ["string","null"],
                            "maxLength": 7,
                            "pattern": "^[0-9]"
                        },
                        "uf": {
                            "required": false,
                            "type": ["string","null"],
                            "minLength": 2,
                            "maxLength": 2
                        },
                        "cnpjlocalacid": {
                            "required": false,
                            "type": ["string","null"],
                            "maxLength": 14,
                            "minLength": 14,
                            "pattern": "^[0-9]"
                        },
                        "pais": {
                            "required": false,
                            "type": ["string","null"],
                            "maxLength": 3,
                            "pattern": "^[0-9]"
                        },
                        "codpostal": {
                            "required": false,
                            "type": ["string","null"],
                            "maxLength": 12
                        }
                    }    
                },
                "parteatingida": {
                    "required": true,
                    "type": "array",
                    "minItems": 1,
                    "maxItems": 99,
                    "items": {
                        "type": "object",
                        "properties": {
                            "codparteating": {
                                "required": true,
                                "type": "string",
                                "minLength": 9,
                                "maxLength": 9,
                                "pattern": "^[0-9]"
                            },
                            "lateralidade": {
                                "required": true,
                                "type": "integer",
                                "minimum": 0,
                                "maximum": 3
                            }
                        }
                    }
                },
                "agentecausador": {
                    "required": true,
                    "type": "array",
                    "minItems": 1,
                    "maxItems": 99,
                    "items": {
                        "type": "object",
                        "properties": {
                            "codagntcausador": {
                                "required": true,
                                "type": "string",
                                "minLength": 9,
                                "maxLength": 9,
                                "pattern": "^[0-9]"
                            }
                        }
                    }    
                },
                "atestado": {
                    "required": false,
                    "type": ["object","null"],
                    "properties": {
                        "codcnes": {
                        },
                        "dtatendimento": {
                        },
                        "hratendimento": {
                        },
                        "indinternacao": {
                        },
                        "durtrat": {
                        },
                        "indafast": {
                        },
                        "dsclesao": {
                        },
                        "dsccomplesao": {
                        },
                        "diagprovavel": {
                        },
                        "codcid": {
                        },
                        "observacao": {
                        },
                        "emitente": {
                            "required": true,
                            "type": "object",
                            "properties": {
                                "nmemit": {
                                },
                                "ideoc": {
                                },
                                "nroc": {
                                },
                                "ufoc": {
                                }
                            }    
                        }
                    }
                },
                "catorigem": {
                    "required": false,
                    "type": ["object","null"],
                    "properties": {
                        "dtcatorig": {
                        },
                        "nrcatorig": {
                            "required": false,
                            "type": ["string","null"],
                            "maxLength": 40
                        }
                    }    
                }
            }
        }
    }
}';

$std = new \stdClass();
$std->sequencial = 1;
$std->indretif = 2;
$std->nrRecibo = '87287hjsh-2982982-jsjhsjhsjh';
$std->tpregistrador = 8;
$std->tpinsc = 1;
$std->nrinsc = '12345678901234';
$std->cpfTrab = '12345678901';
$std->nisTrab = null;

$std->cat = new \stdClass();
$std->cat->dtacid = '2017-11-11';
$std->cat->tpacid = '134.56';
$std->cat->hracid = '2213';
$std->cat->hrstrabantesacid = '0522';
$std->cat->tpcat = 1;
$std->cat->indcatobito = 'N';
$std->cat->dtobito = null;
$std->cat->indcomunpolicia = 'N';
$std->cat->codsitgeradora = '123456789';
$std->cat->iniciatcat = 1;
$std->cat->observacao = null;

$std->cat->localacidente = new \stdClass();
$std->cat->localacidente->tplocal = 1;
$std->cat->localacidente->dsclocal = "area de embalagem";
$std->cat->localacidente->dsclograd = "Rua Micelanea";
$std->cat->localacidente->nrlograd = "2345";
$std->cat->localacidente->codmunic = "35645";
$std->cat->localacidente->uf = "SP";
$std->cat->localacidente->cnpjlocalacid = "12345678901234";
$std->cat->localacidente->pais = "105";
$std->cat->localacidente->codpostal = "04105-070";

$std->cat->parteatingida[0] = new \stdClass();
$std->cat->parteatingida[0]->codparteating = '753510000';
$std->cat->parteatingida[0]->lateralidade = 2;

$std->cat->agentecausador[0] = new \stdClass();
$std->cat->agentecausador[0]->codagntcausador = '200012700';

$std->cat->atestado = new \stdClass();
$std->cat->atestado->codcnes = "";
$std->cat->atestado->dtatendimento = "";
$std->cat->atestado->hratendimento = "";
$std->cat->atestado->indinternacao = "";
$std->cat->atestado->durtrat = "";
$std->cat->atestado->indafast = "";
$std->cat->atestado->dsclesao = "";
$std->cat->atestado->dsccomplesao = "";
$std->cat->atestado->diagprovavel = "";
$std->cat->atestado->codcid = "";
$std->cat->atestado->observacao = "";

$std->cat->atestado->emitente = new \stdClass();
$std->cat->atestado->emitente->nmemit = "";
$std->cat->atestado->emitente->ideoc = "";
$std->cat->atestado->emitente->nroc = "";
$std->cat->atestado->emitente->ufoc = "";

$std->cat->catorigem = new \stdClass();
$std->cat->catorigem->dtcatorig = "";
$std->cat->catorigem->nrcatorig = "";





// Schema must be decoded before it can be used for validation
$jsonSchemaObject = json_decode($jsonSchema);

// The SchemaStorage can resolve references, loading additional schemas from file as needed, etc.
$schemaStorage = new SchemaStorage();

// This does two things:
// 1) Mutates $jsonSchemaObject to normalize the references (to file://mySchema#/definitions/integerData, etc)
// 2) Tells $schemaStorage that references to file://mySchema... should be resolved by looking in $jsonSchemaObject
$schemaStorage->addSchema('file://mySchema', $jsonSchemaObject);

// Provide $schemaStorage to the Validator so that references can be resolved during validation
$jsonValidator = new Validator(new Factory($schemaStorage));

// Do validation (use isValid() and getErrors() to check the result)
$jsonValidator->validate(
    $std,
    $jsonSchemaObject,
    Constraint::CHECK_MODE_COERCE_TYPES  //tenta converter o dado no tipo indicado no schema
);

if ($jsonValidator->isValid()) {
    echo "The supplied JSON validates against the schema.<br/>";
} else {
    echo "JSON does not validate. Violations:<br/>";
    foreach ($jsonValidator->getErrors() as $error) {
        echo sprintf("[%s] %s<br/>", $error['property'], $error['message']);
    }
    die;
}
//salva se sucesso
file_put_contents("../../../jsonSchemes/v$version/$evento.schema", $jsonSchema);
