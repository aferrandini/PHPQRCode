<?php
/**
 * QRrsblock.php
 *
 * Created by arielferrandini
 */
class PHPQRCode_QRrsblock {
        public $dataLength;
        public $data = array();
        public $eccLength;
        public $ecc = array();

        public function __construct($dl, $data, $el, &$ecc, PHPQRCode_QRrsItem $rs)
        {
            $rs->encode_rs_char($data, $ecc);

            $this->dataLength = $dl;
            $this->data = $data;
            $this->eccLength = $el;
            $this->ecc = $ecc;
        }
    };