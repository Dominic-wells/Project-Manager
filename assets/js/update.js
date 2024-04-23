//this function is called when the user clicks on the status button
function updateStatus(newStatus, taskId) {
  fetch("actions/updateTaskStatus.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `status=${newStatus}&taskId=${taskId}`,
  })
    .then((response) => response.json())
    .then((data) => {
      alert(data.message);
      location.reload();
    })
    .catch((error) => console.error("Error:", error));
}

//this function is called when the user clicks on the delete button
function deleteTask(taskId) {
  if (confirm("Are you sure you want to delete this task?")) {
    fetch("actions/deleteTask.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `taskId=${taskId}`,
    })
      .then((response) => response.json())
      .then((data) => {
        alert(data.message);
        location.reload();
      })
      .catch((error) => console.error("Error:", error));
  }
}
