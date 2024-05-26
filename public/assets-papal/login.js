let email = document.getElementById("email");
let emailGroup = document.getElementById("emailGroup");
let loginLabel = document.getElementById("loginLabel");
email.addEventListener("focusout", function () {
  if (email.value) {
    loginLabel.classList.add("focus-fieldLabel");
  } else {
    loginLabel.classList.remove("focus-fieldLabel");
  }
});


let emailVerifiedGroup = document.getElementById("email-verified-group");
let continueBtn = document.getElementById("continueBtn");
// let loader = document.getElementById("loader");
let errorGroup = document.getElementById("error-group");
continueBtn.addEventListener("click", function () {
  // loader.classList.add("show");
  setTimeout(() => {
    // loader.classList.remove("show");
    const isEmailValid = String(email.value)
    .toLowerCase()
    .match(
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );

    if(!email.value.trim() || !isEmailValid){
      errorGroup.classList.remove('hide');
    }else{
      errorGroup.classList.add('hide');
    }
  }, 2000);
});

let changeBtn = document.getElementById("changeBtn");
changeBtn.addEventListener("click", function () {
  emailGroup.classList.remove("hide");
  emailVerifiedGroup.classList.add("hide");
});
