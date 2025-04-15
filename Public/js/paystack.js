const amountModal = document.getElementById("amountModal");
const amountInput = document.getElementById("amountInput");
const email = document.getElementById("email");

const paymentForm = document.getElementById("paymentForm");

// paymentForm.addEventListener('submit', payWithPaystack);

function openAmountModal() {
    amountModal.classList.toggle('active');
}

function closeAmountModal() {
    amountModal.classList.toggle('active');
}



function payWithPaystack(e) {

    e.preventDefault();

    if(amountInput.value === '' || email.value === '' )
    {
        alert('Amount or Email Field is Empty!');
    }
    else
    {
        amountModal.classList.toggle('active');

        let handler = PaystackPop.setup({
            key: 'pk_test_c2c1f4ed3c592dfa02e346f00b3423bb29c44bb7', // Replace with your Paystack public key
            email: email.value, // Customer's email
            amount: amountInput.value * 100, // Amount in kobo (5000 NGN = 500000 kobo)
            callback_url: "http://localhost/dailytrustfund/public/dashboard.php",
            currency: 'NGN', // Currency
            ref: 'TXN_' + Math.floor((Math.random() * 1000000000) + 1), // Unique transaction reference
            callback: function(response) {
                alert('Payment Successful! Transaction Ref: ' + response.reference);
                // TODO: Send reference to your server for verification
                JSON.stringify(response);
            },
            onClose: function() {
                alert('Transaction cancelled.');
            }
        });
        
        handler.openIframe();
    }
    
}
