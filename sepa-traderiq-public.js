(function ($) {
  "use strict";

  $(document).ready(function () {
    var $formContainer = document.querySelectorAll(".form-container");
    for (let i = 0; i < $formContainer.length; i++) {
      var $formP = $formContainer[i].querySelector(".form-p");
      var $close = $formContainer[i].querySelector(".close-form");
      var $formPop = document.querySelectorAll(".form-popup");

      for (let i = 0; i < $formPop.length; i++) {
        $formPop[i].onclick = function () {
          $formContainer[i].querySelector("input").value = "";
          $formContainer[i].style.display = "block";

          //fade In
          setTimeout(function () {
            $formContainer[i].style.opacity = 1;
          }, 50);
        };
      }
      $formContainer[i].onclick = function () {
        //fade out
        $formContainer[i].style.opacity = 0;
        setTimeout(function () {
          $formContainer[i].style.display = "none";
        }, 700);
      };
      $close.onclick = function () {
        $formContainer[i].style.opacity = 0;
        setTimeout(function () {
          $formContainer[i].style.display = "none";
        }, 700);
      };
      $formP.onclick = function (e) {
        e.stopPropagation();
      };
    }

    var stripe = Stripe("pk_test_51I000");
    var elements = stripe.elements();
    // Custom styling can be passed to options when creating an Element.
    var style = {
      base: {
        color: "#32325d",
        fontSize: "16px",
        "::placeholder": {
          color: "#aab7c4",
        },
        ":-webkit-autofill": {
          color: "#32325d",
        },
      },
      invalid: {
        color: "#fa755a",
        iconColor: "#fa755a",
        ":-webkit-autofill": {
          color: "#fa755a",
        },
      },
    };

    var options = {
      style: style,
      supportedCountries: ["SEPA"],
      // Elements can use a placeholder as an example IBAN that reflects
      // the IBAN format of your customer's country. If you know your
      // customer's country, we recommend that you pass it to the Element as the
      // placeholderCountry.
      placeholderCountry: "DE",
    };

    // Create an instance of the IBAN Element
    var iban = elements.create("iban", options);

    // Add an instance of the IBAN Element into the `iban-element` <div>
    iban.mount("#iban-element");
  });
})(jQuery);
