<?php
/**
 * QRrawcode.php
 *
 * Created by arielferrandini
 */
class PHPQRCode_QRrawcode {
    public $version;
    public $datacode = array();
    public $ecccode = array();
    public $blocks;
    public $rsblocks = array(); //of RSblock
    public $count;
    public $dataLength;
    public $eccLength;
    public $b1;

    //----------------------------------------------------------------------
    public function __construct(PHPQRCode_QRinput $input)
    {
        $spec = array(0,0,0,0,0);

        $this->datacode = $input->getByteStream();
        if(is_null($this->datacode)) {
            throw new Exception('null input string');
        }

        PHPQRCode_QRspec::getEccSpec($input->getVersion(), $input->getErrorCorrectionLevel(), $spec);

        $this->version = $input->getVersion();
        $this->b1 = PHPQRCode_QRspec::rsBlockNum1($spec);
        $this->dataLength = PHPQRCode_QRspec::rsDataLength($spec);
        $this->eccLength = PHPQRCode_QRspec::rsEccLength($spec);
        $this->ecccode = array_fill(0, $this->eccLength, 0);
        $this->blocks = PHPQRCode_QRspec::rsBlockNum($spec);

        $ret = $this->init($spec);
        if($ret < 0) {
            throw new Exception('block alloc error');
            return null;
        }

        $this->count = 0;
    }

    //----------------------------------------------------------------------
    public function init(array $spec)
    {
        $dl = PHPQRCode_QRspec::rsDataCodes1($spec);
        $el = PHPQRCode_QRspec::rsEccCodes1($spec);
        $rs = PHPQRCode_QRrs::init_rs(8, 0x11d, 0, 1, $el, 255 - $dl - $el);


        $blockNo = 0;
        $dataPos = 0;
        $eccPos = 0;
        for($i=0; $i<PHPQRCode_QRspec::rsBlockNum1($spec); $i++) {
            $ecc = array_slice($this->ecccode,$eccPos);
            $this->rsblocks[$blockNo] = new PHPQRCode_QRrsblock($dl, array_slice($this->datacode, $dataPos), $el,  $ecc, $rs);
            $this->ecccode = array_merge(array_slice($this->ecccode,0, $eccPos), $ecc);

            $dataPos += $dl;
            $eccPos += $el;
            $blockNo++;
        }

        if(PHPQRCode_QRspec::rsBlockNum2($spec) == 0)
            return 0;

        $dl = PHPQRCode_QRspec::rsDataCodes2($spec);
        $el = PHPQRCode_QRspec::rsEccCodes2($spec);
        $rs = PHPQRCode_QRrs::init_rs(8, 0x11d, 0, 1, $el, 255 - $dl - $el);

        if($rs == NULL) return -1;

        for($i=0; $i<PHPQRCode_QRspec::rsBlockNum2($spec); $i++) {
            $ecc = array_slice($this->ecccode,$eccPos);
            $this->rsblocks[$blockNo] = new PHPQRCode_QRrsblock($dl, array_slice($this->datacode, $dataPos), $el, $ecc, $rs);
            $this->ecccode = array_merge(array_slice($this->ecccode,0, $eccPos), $ecc);

            $dataPos += $dl;
            $eccPos += $el;
            $blockNo++;
        }

        return 0;
    }

    //----------------------------------------------------------------------
    public function getCode()
    {
        $ret = null;

        if($this->count < $this->dataLength) {
            $row = $this->count % $this->blocks;
            $col = $this->count / $this->blocks;
            if($col >= $this->rsblocks[0]->dataLength) {
                $row += $this->b1;
            }
            $ret = $this->rsblocks[$row]->data[$col];
        } else if($this->count < $this->dataLength + $this->eccLength) {
            $row = ($this->count - $this->dataLength) % $this->blocks;
            $col = ($this->count - $this->dataLength) / $this->blocks;
            $ret = $this->rsblocks[$row]->ecc[$col];
        } else {
            return 0;
        }
        $this->count++;

        return $ret;
    }
}