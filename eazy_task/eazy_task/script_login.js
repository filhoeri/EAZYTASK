const loginBtn = document.getElementById("loginBtn");
const usernameInput = document.getElementById("username");
const passwordInput = document.getElementById("password");
const errorDisplay = document.getElementById("error");

// Simulasi data pengguna
const users = [
  { username: "user", password: "1234" },
  { username: "user2", password: "password2" },
];

// Fungsi untuk menangani login
loginBtn.addEventListener("click", () => {
  const username = usernameInput.value;
  const password = passwordInput.value;

  const user = users.find(
    (u) => u.username === username && u.password === password
  );

  if (user) {
    // Jika login berhasil, simpan status login dan redirect ke halaman utama
    localStorage.setItem("loggedIn", "true");
    window.location.href = "index.html";
  } else {
    // Tampilkan pesan error jika login gagal
    errorDisplay.textContent = "Username atau password salah!";
  }
});
