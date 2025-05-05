document
  .getElementById("forgotPasswordForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    let email = document.getElementById("email").value;
    let message = document.getElementById("message");

    if (email) {
      message.style.color = "green";
      message.innerText = "Password reset link sent to " + email;
      document.getElementById("email").value = "";
    } else {
      message.style.color = "red";
      message.innerText = "Please enter a valid email.";
    }
  });
