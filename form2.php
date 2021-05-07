<?php

$Vorname = $_POST['Vorname'];
$Nachname = $_POST['Nachname'];
$email = $_POST['email'];
$ggfFirma = $_POST['ggfFirma'];
$StraßeHausnummer = $_POST['StraßeHausnummer'];
$PLZ = $_POST['PLZ'];
$Ort = $_POST['Ort'];
$IBAN = $_POST['IBAN'];
$BIC = $_POST['BIC'];
$amount = $_POST['amount'];
$description = $_POST['description'];
$tag_quentn = $_POST['tag_quentn'];

$ggfFirma2 = str_replace(' ', '%20', $ggfFirma);
$StraßeHausnummer2 = str_replace(' ', '%20', $StraßeHausnummer);
$Ort2 = str_replace(' ', '%20', $Ort);
$name = $Vorname.'%20'.$Nachname;
$mailpost = str_replace('@', '%40', $email);

$description2 = str_replace(' ', '%20', $description);

$curl_mail = curl_init();

curl_setopt_array($curl_mail, array(
  CURLOPT_URL => 'https://api.stripe.com/v1/customers',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_POSTFIELDS => 'email='.$mailpost.'',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer sk_test_51I5rr000',
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$mailcheck = curl_exec($curl_mail);

curl_close($curl_mail);
$mail_dub = json_decode($mailcheck);

$mail_dub->data['0']->email;

if ($email !== $mail_dub->data['0']->email) {
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.stripe.com/v1/customers',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'name='.$name.'&email='.$mailpost.'&address%5Bcity%5D='.$Ort2.'&address%5Bline1%5D='.$StraßeHausnummer2.'&address%5Bpostal_code%5D='.$PLZ.'&metadata%5BggfFirma%5D='.$ggfFirma2.'',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer sk_test_51I5r00',
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$Payments = curl_exec($curl);
curl_close($curl);

$json_client = json_decode($Payments);

$id_customer = $json_client->id;

};

$id_dubl = $mail_dub->data['0']->id;
$id_total = $email !== $mail_dub->data['0']->email? $id_customer: $id_dubl;

$PaymentIntent = curl_init();

curl_setopt_array($PaymentIntent, array(
  CURLOPT_URL => 'https://api.stripe.com/v1/payment_intents',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'amount='.$amount.'&currency=eur&payment_method_types%5B%5D=sepa_debit&setup_future_usage=off_session&customer='.$id_total.'&metadata%5Bintegration_checker%5D=sepa_debit_accept_a_payment&payment_method_data%5Btype%5D=sepa_debit&payment_method_data%5Bsepa_debit%5D%5Biban%5D='.$IBAN.'&payment_method_data%5Bbilling_details%5D%5Bname%5D='.$name.'&payment_method_data%5Bbilling_details%5D%5Bemail%5D='.$mailpost.'&description='.$description2.'',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer sk_test_51I5rr000',
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$Payments = curl_exec($PaymentIntent);
curl_close($PaymentIntent);

$json_paym = json_decode($Payments);

$cl_sec = $json_paym->client_secret;
// Reg Quentn

$name2 = $Vorname.' '.$Nachname;

$id_qn2 = array_map('intval', explode(',', $tag_quentn));

$arr_qn2 = array
('contact' =>
  array (
    'first_name' => $name2,
    'mail' => $email,
    'terms' => $id_qn2,
    'duplicate_check_method' => 'email',
    'duplicate_merge_method' => 'update_add',
    'return_fields' => array(
                    '0' => 'email-status',
                    '1' => 'mail')
));

$json_arr_qn2 = json_encode($arr_qn2, true);



$curl_qn = curl_init();

curl_setopt_array($curl_qn, array(
  CURLOPT_URL => 'https://q0ydly.eu-2.quentn.com/public/api/v1/contact',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => $json_arr_qn2,
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer bR_2IbjgC00',
    'Content-Type: text/plain'
  ),
));

$response_qn = curl_exec($curl_qn);
curl_close($curl_qn);

$data_cl_qn = json_decode($response_qn, true);


?>
<script>
  	var stripe = Stripe('pk_test_51I5rro000');
var elements = stripe.elements();

var form = document.getElementById("payment-form");
    var accountholderName = document.getElementById("accountholder-name");
    var email = document.getElementById("email");
    var submitButton = document.getElementById("submit-button");
    var clientSecret = <?php echo $cl_sec;?>;

    form.addEventListener("submit", function (event) {
      event.preventDefault();
      stripe.confirmSepaDebitPayment(clientSecret, {
        payment_method: {
          sepa_debit: <?php echo $IBAN;?>,
          billing_details: {
            name: <?php echo $Vorname;?>,
            email: <?php echo $email;?>,
          },
        },
      });
    });
</script>
<?php
/* $redirect_yes = 'https://traderiq.net/vielen-dank-deine-bestellung-des-masterminds-trading-gmbh/';
echo "<script>window.location.href='".$redirect_yes."';</script>"; */
