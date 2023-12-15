const video = document.getElementById("videoElement");

navigator.mediaDevices
    .getUserMedia({ video: true })
    .then((stream) => {
        video.srcObject = stream;
    })
    .catch((err) => {
        console.error("Error accessing the webcam: ", err);
    });

const captureButton = document.getElementById("captureBtn");

captureButton.addEventListener("click", async () => {
    const canvas = document.createElement("canvas");
    const ctx = canvas.getContext("2d");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    const dataURL = canvas.toDataURL("image/jpeg");
    try {
        const response = await fetch("http://localhost:80/my_api/index.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ image: dataURL }),
        });
        // const responseData = await response.json();
        // console.log("Server Response:", responseData);
        const data = await response.text();
        console.log(data);
    } catch (error) {
        console.error("Error sending image to the server:", error);
    }
});
