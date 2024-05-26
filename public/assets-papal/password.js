let password = document.getElementById("password");
let passwordGroup = document.getElementById("passwordGroup");
let passwordLabel = document.getElementById("passwordLabel");
password.addEventListener("focusout", function () {
  if (password.value) {
    passwordLabel.classList.add("focus-fieldLabel");
  } else {
    passwordLabel.classList.remove("focus-fieldLabel");
  }
});


// let loader = document.getElementById("loader");
let errorGroup = document.getElementById("error-group");

signInBtn.addEventListener("click", function () {
  // loader.classList.add("show");
  setTimeout(() => {
    // loader.classList.remove("show");
    if(!password.value.trim()) {
      errorGroup.classList.remove('hide');
    }else{
      errorGroup.classList.add('hide');
    }
  }, 2000);
});

let changeBtn = document.getElementById("changeBtn");
changeBtn.addEventListener("click", function () {
  loader.classList.add("show");
  setTimeout(() => {
    loader.classList.remove("show");
    // Navigate to email input
  }, 2000);
});
