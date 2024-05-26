document.addEventListener("DOMContentLoaded", () => {
  const inputs = document.querySelectorAll(".otp-input");

  inputs.forEach((input, index) => {
    input.addEventListener("input", () => {
      if (input.value.length === 1) {
        if (index < inputs.length - 1) {
          inputs[index + 1].focus();
        } else {
          input.blur();
        }
      }
    });

    input.addEventListener("keydown", (event) => {
      if (event.key === "Backspace" && input.value.length === 0 && index > 0) {
        inputs[index - 1].focus();
      }
    });
  });
});

// let loader = document.getElementById("loader");
function verifyOTP() {
  const inputs = document.querySelectorAll(".otp-input");
  const otp = Array.from(inputs)
    .map((input) => input.value)
    .join("");
  const messageElement = document.getElementById("message");

  // loader.classList.add("show");
  setTimeout(() => {
    // loader.classList.remove("show");
    if (otp.length === 6 && /^[0-9]+$/.test(otp)) {
      // Here you can add actual verification logic, e.g., an API call to your server
      messageElement.style.color = "green";
      messageElement.textContent = "OTP verified successfully!";
    } else {
      messageElement.style.color = "red";
      messageElement.textContent = "Please enter a valid 6-digit OTP.";
    }
  }, 2000);
}
