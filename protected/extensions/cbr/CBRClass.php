<?php

class CBRClass extends CApplicationComponent
{
    public $usd;
    public $euro;
    public $cbUrl;
    private $_cbPath;
    private $_cbFile;

    public function init()
    {
        $this->_cbPath = YiiBase::getPathOfAlias('webroot.upload.cbr').'/';
        $this->_cbFile = $this->_cbPath.date('dmY').'.php';
        if (file_exists($this->_cbFile)) {
            include_once ($this->_cbFile);
        }
        else {
            $data = file_get_contents($this->cbUrl.date('d/m/Y'));
            $xml = new SimpleXMLElement($data);
            foreach ($xml->Valute as $Currency) {
                switch((integer)$Currency->NumCode) {
                    case 840: $usd = floatval(str_replace(",", ".", (string)$Currency->Value));
                        break;
                    case 978: $eur = floatval(str_replace(",", ".", (string)$Currency->Value));
                        break;
                }
            }
            $fileContent = '<?php $usd = '.number_format($usd, 4, '.', '').'; $eur = '.number_format($eur, 4, '.', '').'; ?>';
            file_put_contents ($this->_cbFile, $fileContent);
        }
        $this->usd = $usd;
        $this->euro = $eur;
    }
}