
function togglePassword(inputId, icon) {
    const passwordInput = document.getElementById(inputId);
    
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        // မျက်လုံးပိတ်ကနေ မျက်လုံးဖွင့် icon ပြောင်းမယ်
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        passwordInput.type = "password";
        // မျက်လုံးဖွင့်ကနေ မျက်လုံးပိတ် icon ပြန်ပြောင်းမယ်
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
}