<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once('assets/libraries/dompdf/autoload.inc.php');

use Dompdf\Dompdf;

class Pdf
{


        private $dompdf;

        public function __construct()
        {
                $this->dompdf = new Dompdf();
        }

        public function print_now($data, $orientation = 'portrait')
        {
                $this->dompdf->loadHtml($data);

                // (Optional) Setup the paper size and orientation
                $this->dompdf->setPaper('A4', $orientation);

                // Render the HTML as PDF
                $this->dompdf->render();

                // Output the generated PDF to Browser
                $this->dompdf->stream();
        }

}
