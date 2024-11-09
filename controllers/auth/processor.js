function ajaxSubmitForm(formId, url, redirectUrl = null) {
  let isSubmitting = false; // Submission flag
  const minimumDelay = 1000; // Minimum delay in milliseconds (1 second)

  $(formId).on("submit", function (e) {
    e.preventDefault();

    // Prevent further submissions if already submitting
    if (isSubmitting) return;
    isSubmitting = true;

    const formData = $(this).serialize();
    const submitButtons = $(this).find(":submit"); // Target submit buttons

    // Disable all submit buttons and add the spinner
    submitButtons
      .prop("disabled", true)
      .addClass("disabled-btn")
      .html(
        'Submitting... <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
      );

    const startTime = Date.now(); // Track the start time for delay calculation

    $.ajax({
      type: "POST",
      url: url,
      data: formData,
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          if (response.messages && Array.isArray(response.messages)) {
            response.messages.forEach(function (message) {
              iziToast.success({
                title: "Success",
                message: message || "Form submitted successfully!",
                position: "topRight",
                timeout: 5000,
                progressBar: true,
                close: true,
                icon: "fas fa-check-circle",
                transitionIn: "fadeInDown",
                transitionOut: "fadeOutUp",
              });
            });
            if (response.redirect) {
              setTimeout(() => {
                window.location.href = response.redirect;
              }, 500);
            } else if (redirectUrl) {
              setTimeout(() => {
                window.location.href = redirectUrl;
              }, 500);
            }
          }
        } else {
          if (response.messages && Array.isArray(response.messages)) {
            response.messages.forEach(function (message) {
              showErrorToast(message, 10000);
            });
          } else {
            showErrorToast("An unexpected error occurred.");
          }
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("AJAX Error: " + textStatus + " - " + errorThrown);
        showErrorToast("Failed to submit the form. Please try again later.");
      },
      complete: function () {
        const elapsed = Date.now() - startTime;
        const remainingDelay = minimumDelay - elapsed;

        // Delay re-enabling the button if necessary
        setTimeout(
          () => {
            submitButtons
              .prop("disabled", false)
              .removeClass("disabled-btn")
              .html("Submit"); // Reset the button text

            isSubmitting = false;
          },
          remainingDelay > 0 ? remainingDelay : 0
        );
      },
    });
  });
}

// Function to show an error toast using iziToast
function showErrorToast(message) {
  iziToast.error({
    title: "Error",
    message: message,
    position: "topRight",
    timeout: 5000,
    progressBar: true,
    close: true,
    icon: "fas fa-exclamation-triangle",
    transitionIn: "fadeInDown",
    transitionOut: "fadeOutUp",
    backgroundColor: "#b71c1c",
  });
}

$(document).ready(function () {
  ajaxSubmitForm("#signUpForm", "controllers/auth/form_processor.php", "home");
  ajaxSubmitForm("#signInForm", "controllers/auth/form_processor.php", "home");
  ajaxSubmitForm("#depositForm", "controllers/user/deposit_processor.php", "upload");
});