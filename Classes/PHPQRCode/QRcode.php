<?php
/**
 * QRcode.php
 *
 * Created by arielferrandini
 */

class PHPQRCode_QRcode {

        public $version;
        public $width;
        public $data;

        //----------------------------------------------------------------------
        public function encodeMask(PHPQRCode_QRinput $input, $mask)
        {
            if($input->getVersion() < 0 || $input->getVersion() > PHPQRCode_Config::QRSPEC_VERSION_MAX) {
                throw new Exception('wrong version');
            }
            if($input->getErrorCorrectionLevel() > PHPQRCode_Config::QR_ECLEVEL_H) {
                throw new Exception('wrong level');
            }

            $raw = new PHPQRCode_QRrawcode($input);

            PHPQRCode_QRtools::markTime('after_raw');

            $version = $raw->version;
            $width = PHPQRCode_QRspec::getWidth($version);
            $frame = PHPQRCode_QRspec::newFrame($version);

            $filler = new PHPQRCode_FrameFiller($width, $frame);
            if(is_null($filler)) {
                return NULL;
            }

            // inteleaved data and ecc codes
            for($i=0; $i<$raw->dataLength + $raw->eccLength; $i++) {
                $code = $raw->getCode();
                $bit = 0x80;
                for($j=0; $j<8; $j++) {
                    $addr = $filler->next();
                    $filler->setFrameAt($addr, 0x02 | (($bit & $code) != 0));
                    $bit = $bit >> 1;
                }
            }

            PHPQRCode_QRtools::markTime('after_filler');

            unset($raw);

            // remainder bits
            $j = PHPQRCode_QRspec::getRemainder($version);
            for($i=0; $i<$j; $i++) {
                $addr = $filler->next();
                $filler->setFrameAt($addr, 0x02);
            }

            $frame = $filler->frame;
            unset($filler);


            // masking
            $maskObj = new PHPQRCode_QRmask();
            if($mask < 0) {

                if (PHPQRCode_Config::QR_FIND_BEST_MASK) {
                    $masked = $maskObj->mask($width, $frame, $input->getErrorCorrectionLevel());
                } else {
                    $masked = $maskObj->makeMask($width, $frame, (intval(PHPQRCode_Config::QR_DEFAULT_MASK) % 8), $input->getErrorCorrectionLevel());
                }
            } else {
                $masked = $maskObj->makeMask($width, $frame, $mask, $input->getErrorCorrectionLevel());
            }

            if($masked == NULL) {
                return NULL;
            }

            PHPQRCode_QRtools::markTime('after_mask');

            $this->version = $version;
            $this->width = $width;
            $this->data = $masked;

            return $this;
        }

        //----------------------------------------------------------------------
        public function encodeInput(PHPQRCode_QRinput $input)
        {
            return $this->encodeMask($input, -1);
        }

        //----------------------------------------------------------------------
        public function encodeString8bit($string, $version, $level)
        {
            if(string == NULL) {
                throw new Exception('empty string!');
                return NULL;
            }

            $input = new PHPQRCode_QRinput($version, $level);
            if($input == NULL) return NULL;

            $ret = $input->append($input, PHPQRCode_Config::QR_MODE_8, strlen($string), str_split($string));
            if($ret < 0) {
                unset($input);
                return NULL;
            }
            return $this->encodeInput($input);
        }

        //----------------------------------------------------------------------
        public function encodeString($string, $version, $level, $hint, $casesensitive)
        {

            if($hint != PHPQRCode_Config::QR_MODE_8 && $hint != PHPQRCode_Config::QR_MODE_KANJI) {
                throw new Exception('bad hint');
                return NULL;
            }

            $input = new PHPQRCode_QRinput($version, $level);
            if($input == NULL) return NULL;

            $ret = PHPQRCode_QRsplit::splitStringToQRinput($string, $input, $hint, $casesensitive);
            if($ret < 0) {
                return NULL;
            }

            return $this->encodeInput($input);
        }

        //----------------------------------------------------------------------
        public static function png($text, $outfile = false, $level = PHPQRCode_Config::QR_ECLEVEL_L, $size = 3, $margin = 4, $saveandprint=false)
        {
            $enc = PHPQRCode_QRencode::factory($level, $size, $margin);
            return $enc->encodePNG($text, $outfile, $saveandprint=false);
        }

        //----------------------------------------------------------------------
        public static function text($text, $outfile = false, $level = PHPQRCode_Config::QR_ECLEVEL_L, $size = 3, $margin = 4)
        {
            $enc = PHPQRCode_QRencode::factory($level, $size, $margin);
            return $enc->encode($text, $outfile);
        }

        //----------------------------------------------------------------------
        public static function raw($text, $outfile = false, $level = PHPQRCode_Config::QR_ECLEVEL_L, $size = 3, $margin = 4)
        {
            $enc = PHPQRCode_QRencode::factory($level, $size, $margin);
            return $enc->encodeRAW($text, $outfile);
        }
    }