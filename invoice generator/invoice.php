<?php
function RotatedText($x, $y, $txt, $angle)
{
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
}

require('alpha.php');
require('indian_number.php');
$customer_name="Bandi Yugandhar";
$customer_street="Rajanagar";
$customer_city="Madanapalli";
$customer_mobile_number="(+91)9494555549";

date_default_timezone_set('Asia/Kolkata');
$date= date('d/F/Y');

$Invoice_number="1234567";
$Customer_ID="1234567";

$tool_name="Research Tool";
$total=5001;
$Internet_charges=(5/100)*$total;
$GST=(18/100)*$total;
$subtotal=$total-($Internet_charges+$GST);
$total=numberToCurrency(round($total,2));
$Internet_charges=numberToCurrency(round($Internet_charges,2));
$GST=numberToCurrency(round($GST,2));
$subtotal=numberToCurrency(round($subtotal,2));

//create pdf object
$pdf = new AlphaPDF('P','mm','A4');

//add new page
$pdf->AddPage();

$pdf->SetFont('Arial','B',14);

$pdf->SetAlpha(0.4);
$pdf->RotatedImage('logo.jpg',35,100,150,90,45);
$pdf->SetAlpha(1);

$pdf->SetTextColor(255, 93, 0);
$pdf->Cell(130 ,5,'SELLER GYAN',0,0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(59 ,5,'INVOICE',0,1);//end of line

//set font to arial, regular, 12pt

$pdf->SetFont('Arial','',12);
$pdf->Cell(59 ,5,'',0,1);//end of line
$pdf->Cell(130 ,5,'[Manikonda]',0,0);
$pdf->Cell(25 ,5,'Date',0,0);
$pdf->Cell(34 ,5,$date,0,1);//end of line

// $pdf->Cell(59 ,5,'',0,1);//end of line

$pdf->Cell(130 ,5,'[Hyderabad, India, 500089]',0,0);
$pdf->Cell(25 ,5,'Invoice #',0,0);
$pdf->Cell(34 ,5,'['.$Invoice_number.']',0,1);//end of line
$pdf->Cell(130 ,5,'Phone [(+91)9494555549]',0,0);
$pdf->Cell(25 ,5,'Customer ID',0,0);
$pdf->Cell(34 ,5,'['.$Customer_ID.']',0,1);//end of line

$pdf->Cell(189 ,10,'',0,1);//end of line

//billing address
$pdf->Cell(100 ,5,'Bill to',0,1);//end of line
$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,'['.$customer_name.']',0,1);
$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,'['.$customer_street.', '.$customer_city.']',0,1);
$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,'['.$customer_mobile_number.']',0,1);
$pdf->Cell(189 ,10,'',0,1);//end of line

//invoice contents
$pdf->SetFont('Arial','B',12);
$pdf->Cell(130 ,5,'Description',1,0);
$pdf->Cell(25 ,5,'Taxable',1,0);
$pdf->Cell(34 ,5,'Amount',1,1);//end of line
$pdf->SetFont('Arial','',12);


$pdf->Cell(130 ,5,$tool_name,1,0);
$pdf->Cell(25 ,5,'-',1,0);
$pdf->Cell(34 ,5,$subtotal,1,1,'R');//end of line

//summary
$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'Subtotal',0,0);
$pdf->Cell(7 ,5,'Rs',1,0);
$pdf->Cell(30 ,5,$subtotal,1,1,'R');//end of line

$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'IHC(5%)',0,0);
$pdf->Cell(7 ,5,'Rs',1,0);
$pdf->Cell(30 ,5,$Internet_charges,1,1,'R');//end of line

$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'GST(18%)',0,0);
$pdf->Cell(7 ,5,'Rs',1,0);
$pdf->Cell(30 ,5,$GST,1,1,'R');//end of line

$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'Total',0,0);
$pdf->Cell(7 ,5,'Rs',1,0);
$pdf->Cell(30 ,5,$total,1,1,'R');//end of line
//output the result
$pdf->Output();


// email stuff (change data below)
$to = "yugandhar.bunny.2220@gmail.com"; 
$from = "sellergyan@sellergyan.com"; 
$subject = "Invoice for your purchase"; 
$message = "<p>Please find the attachment.</p>";

// a random hash will be necessary to send mixed content
$separator = md5(time());

// carriage return type (we use a PHP end of line constant)
$eol = PHP_EOL;

// attachment name
$filename = "test.pdf";

// encode data (puts attachment in proper format)
$pdfdoc = $pdf->Output("", "S");
$attachment = chunk_split(base64_encode($pdfdoc));

// main header
$headers  = "From: ".$from.$eol;
$headers .= "MIME-Version: 1.0".$eol; 
$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

// no more headers after this, we start the body! //

$body = "--".$separator.$eol;
$body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
// $body .= "This is a MIME encoded message.".$eol;

// message
$body .= "--".$separator.$eol;
$body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
$body .= $message.$eol;

// attachment
$body .= "--".$separator.$eol;
$body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
$body .= "Content-Transfer-Encoding: base64".$eol;
$body .= "Content-Disposition: attachment".$eol.$eol;
$body .= $attachment.$eol;
$body .= "--".$separator."--";

// send message
// mail($to, $subject, $body, $headers);









?>