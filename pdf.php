<?php

// reference the Dompdf namespace
require_once "dompdf/autoload.inc.php";

use Dompdf\Dompdf;

function pdf_file_response($html) {

    // instantiate and use the dompdf class
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    
    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');
    
    // Render the HTML as PDF
    $dompdf->render();
    
    // Output the generated PDF to Browser
    $dompdf->stream();

}    


$html = "
<table border= 1>
    <tr>
        <td>Jeewan</td>
    </tr>
    <tr>
    <td>Jeewan</td>
</tr>
<tr>
<td>Jeewan</td>
</tr>
</table>
";

pdf_file_response($html);