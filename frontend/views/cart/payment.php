<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 09.09.2021
 * Time: 12:28
 * User: WyTcorporation
 */

use yii\helpers\Html;

?>
<?=$html?>

<div id="liqpay_checkout"></div>
<script>
    window.LiqPayCheckoutCallback = function() {
        LiqPayCheckout.init({
            data: "<?=$data?>",
            signature: "<?=$signature?>",
            embedTo: "#liqpay_checkout",
            mode: "popup" // embed || popup,
        }).on("liqpay.callback", function(data){
            console.log(data.status);
            console.log(data);
        }).on("liqpay.ready", function(data){
            // ready
        }).on("liqpay.close", function(data){
            // close
       });
    };
</script>
<script src="//static.liqpay.ua/libjs/checkout.js" async></script>
