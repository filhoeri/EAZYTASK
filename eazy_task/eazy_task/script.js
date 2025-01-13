const taskInput = document.getElementById("taskInput");
const addTaskBtn = document.getElementById("addTaskBtn");
const taskList = document.getElementById("taskList");
const searchInput = document.getElementById("search");
const priorityCheckbox = document.getElementById("priorityCheckbox");
const logoutBtn = document.getElementById("logoutBtn");

// Cek status login
if (!localStorage.getItem("loggedIn")) {
  window.location.href = "login.html"; // Redirect ke halaman login jika belum login
}

let tasks = [];
let editIndex = -1;

// Fungsi untuk menampilkan tugas
function displayTasks() {
  taskList.innerHTML = "";
  tasks.forEach((task, index) => {
    const li = document.createElement("li");

    // Menandai tugas penting
    const taskText = document.createElement("span");
    taskText.textContent = task.text;
    if (task.isPriority) {
      taskText.classList.add("priority");
    }
    if (task.isCompleted) {
      taskText.classList.add("completed");
    }
    li.appendChild(taskText);

    // Tombol Tandai Selesai
    const completeBtn = document.createElement("button");
    completeBtn.textContent = task.isCompleted ? "Belum Selesai" : "Selesai";
    completeBtn.className = "complete-btn";
    completeBtn.onclick = () => completeTask(index);

    // Tombol Edit
    const editBtn = document.createElement("button");
    editBtn.textContent = "Edit";
    editBtn.className = "edit-btn";
    editBtn.onclick = () => editTask(index);

    // Tombol Hapus
    const deleteBtn = document.createElement("button");
    deleteBtn.textContent = "Hapus";
    deleteBtn.className = "delete-btn";
    deleteBtn.onclick = () => deleteTask(index);

    li.appendChild(completeBtn);
    li.appendChild(editBtn);
    li.appendChild(deleteBtn);
    taskList.appendChild(li);
  });
}

// Fungsi untuk menambahkan atau mengedit tugas
addTaskBtn.addEventListener("click", () => {
  const taskText = taskInput.value.trim();
  const isPriority = priorityCheckbox.checked; // Cek apakah tugas penting

  if (taskText) {
    if (editIndex === -1) {
      tasks.push({
        text: taskText,
        isPriority: isPriority,
        isCompleted: false,
      });
    } else {
      tasks[editIndex] = {
        text: taskText,
        isPriority: isPriority,
        isCompleted: tasks[editIndex].isCompleted,
      };
      editIndex = -1; // Reset editIndex setelah edit
    }
    taskInput.value = "";
    priorityCheckbox.checked = false; // Reset checkbox
    displayTasks();
  }
});

// Fungsi untuk mengedit tugas
function editTask(index) {
  taskInput.value = tasks[index].text;
  priorityCheckbox.checked = tasks[index].isPriority; // Set checkbox sesuai status prioritas
  editIndex = index; // Set editIndex ke index tugas yang diedit
}

// Fungsi untuk menghapus tugas
function deleteTask(index) {
  tasks.splice(index, 1); // Hapus tugas dari array
  displayTasks(); // Tampilkan ulang daftar tugas
}

// Fungsi untuk menandai tugas sebagai selesai
function completeTask(index) {
  tasks[index].isCompleted = !tasks[index].isCompleted; // Toggle status selesai
  displayTasks(); // Tampilkan ulang daftar tugas
}

// Fungsi untuk mencari tugas
searchInput.addEventListener("input", () => {
  const searchTerm = searchInput.value.toLowerCase();
  const filteredTasks = tasks.filter((task) =>
    task.text.toLowerCase().includes(searchTerm)
  );
  taskList.innerHTML = "";
  filteredTasks.forEach((task, index) => {
    const li = document.createElement("li");

    // Menandai tugas penting
    const taskText = document.createElement("span");
    taskText.textContent = task.text;
    if (task.isPriority) {
      taskText.classList.add("priority");
    }
    if (task.isCompleted) {
      taskText.classList.add("completed");
    }
    li.appendChild(taskText);

    // Tombol Tandai Selesai
    const completeBtn = document.createElement("button");
    completeBtn.textContent = task.isCompleted ? "Belum Selesai" : "Selesai";
    completeBtn.className = "complete-btn";
    completeBtn.onclick = () => completeTask(tasks.indexOf(task));

    // Tombol Edit
    const editBtn = document.createElement("button");
    editBtn.textContent = "Edit";
    editBtn.className = "edit-btn";
    editBtn.onclick = () => editTask(tasks.indexOf(task));

    // Tombol Hapus
    const deleteBtn = document.createElement("button");
    deleteBtn.textContent = "Hapus";
    deleteBtn.className = "delete-btn";
    deleteBtn.onclick = () => deleteTask(tasks.indexOf(task));

    li.appendChild(completeBtn);
    li.appendChild(editBtn);
    li.appendChild(deleteBtn);
    taskList.appendChild(li);
  });
});

// Fungsi untuk logout
logoutBtn.addEventListener("click", () => {
  localStorage.removeItem("loggedIn"); // Hapus status login
  window.location.href = "login.html"; // Redirect ke halaman login
});
