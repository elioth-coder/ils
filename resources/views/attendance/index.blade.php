<x-layout>
    <x-slot:head>
        <script src="/js/face-api.min.js"></script>
        <style>
            .swal2-image.profile {
                border-radius: 50%;
                object-fit: cover;
            }

            #video-container {
                position: fixed;
                width: 100%;
                height: 100%;
                overflow: hidden;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.25);
                z-index: 10;
            }

            th {
                position: sticky;
                top: 0;
                background-color: #f8f8f8;
                z-index: 1;
            }
        </style>
    </x-slot:head>
    <main class="d-flex align-items-center justify-content-center w-100 bg-primary position-relative"
        style="height: calc(100vh - 60px);">
        <div id="video-container" style="display:none;" class="align-items-center justify-content-center">
            <div id="video-frame" class="bg-white card border shadow position-relative p-1">
                <canvas id="hidden-canvas" class="d-none"></canvas>
                <video id="video" class="rounded" width="500" height="375" autoplay></video>
                <button onclick="stopFaceRecognition();" class="btn btn-danger position-absolute top-0 end-0 m-1 z-1">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>
        <div class="w-full text-center bg-warning rounded-5 rounded-start-0 text-white fw-bold p-4">
            <a href="/">Home</a>
        </div>
        <div class="d-flex py-5 w-100">
            <div class="w-50 p-5 text-center">
                <img src="/images/papaya-campus-logo.png" class="mx-auto" style="width: 220px;" alt="">
                <h1>NEUST LIBRARY <br>Attendance Monitoring</h1>
                <br>
                <div class="w-50 mx-auto">
                    <input id="barcode_reader" placeholder="Scan your library card" type="text"
                        class="text-center form-control form-control-lg" autofocus="on" autocomplete="off" />
                </div>
                <h5 class="my-3">or use</h5>
                <div class="w-50 mx-auto">
                    <button onclick="startFaceRecognition()" class="btn btn-warning btn-lg">
                        <i class="bi bi-person-bounding-box me-1"></i>
                        Face Recognition
                    </button>
                </div>
            </div>
            <div class="w-50 p-5">
                <h2 class="text-center mt-5 mb-4 text-warning text-decoration-underline">Attendance Log</h2>
                <div class="bg-white mx-5 px-2 border rounded" style="overflow-y: scroll; max-height: 380px;">
                    <table class="table" id="attendance-log-table">
                        <thead class="text-uppercase">
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Program</th>
                            <th>In</th>
                            <th>Out</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $attendance)
                                <tr>
                                    <td class="text-end">{{ $loop->index + 1 }}.</td>
                                    <td class="text-capitalize">{{ $attendance->name }}</td>
                                    <td>{{ $attendance->program }}</td>
                                    <td><b>{{ date('h:i A', strtotime($attendance->in)) }}</b></td>
                                    @if($attendance->out)
                                        <td class="text-success">
                                            <b>{{ date('h:i A', strtotime($attendance->out)) }}</b>
                                        </td>
                                    @else
                                        <td class="text-danger"><b>--:-- --</b></td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <footer class="bg-primary" style="height: 60px;">
        <div class="w-100 p-3">
            <p class="text-center m-0">
                Copyright &copy; 2024 |
                <a href="/" class="link-hover link-dark text-decoration-none">NEUST ILI v1.0.0</a>
            </p>
        </div>
    </footer>
    <x-slot:script>
        <script>
            let video;

            function base64ToFile(base64Data, filename, mimeType) {
                // Remove the base64 prefix (if present)
                let cleanedBase64 = base64Data.replace(/^data:.+;base64,/, '');

                // Decode the base64 string into a byte array
                let byteCharacters = atob(cleanedBase64);

                // Create a typed array from the decoded data
                let byteArray = new Uint8Array(byteCharacters.length);

                // Populate the byte array with the decoded data
                for (let i = 0; i < byteCharacters.length; i++) {
                    byteArray[i] = byteCharacters.charCodeAt(i);
                }

                // Create a Blob from the byte array
                let blob = new Blob([byteArray], {
                    type: mimeType
                });

                // Create a File from the Blob
                let file = new File([blob], filename, {
                    type: mimeType
                });

                return file;
            }

            function base64ToBlob(base64, mimeType) {
                const byteCharacters = atob(base64);
                const byteNumbers = new Array(byteCharacters.length);
                for (let i = 0; i < byteCharacters.length; i++) {
                    byteNumbers[i] = byteCharacters.charCodeAt(i);
                }
                const byteArray = new Uint8Array(byteNumbers);
                return new Blob([byteArray], {
                    type: mimeType
                });
            }

            const startFaceRecognition = () => {
                document.querySelector('#video-container').style.display = 'flex';

                navigator.mediaDevices
                    .getUserMedia({
                        video: true,
                        audio: false,
                    })
                    .then((stream) => {
                        video.srcObject = stream;
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            };

            const pauseFaceRecognition = () => {
                if (video) {
                    video.pause();
                }
            }

            const resumeFaceRecognition = () => {
                if (video) {
                    video.play();
                }
            }

            const stopFaceRecognition = () => {
                document.querySelector('#video-container').style.display = 'none';

                if (video && video.srcObject) {
                    const tracks = video.srcObject.getTracks();

                    tracks.forEach((track) => {
                        track.stop();
                    });

                    video.srcObject = null;
                }
            };

            async function findFaceMatch(imageData) {
                let formData = new FormData();
                // formData.set('image_data', imageData);
                let file = base64ToFile(imageData, "face.png", "image/png");
                formData.append('file', file);

                let response = await fetch('http://localhost:3000/find_face_match', {
                    method: 'POST',
                    body: formData,
                });

                let _response = await response.json();

                return _response;
            }

            async function asyncRecursion(fn) {
                await fn();
                asyncRecursion(fn);
            }

            const handleVideo = () => {
                if (!video) return;

                const canvas = faceapi.createCanvasFromMedia(video);
                canvas.style.position = "absolute";
                canvas.style.top = "0";
                canvas.style.left = "0";
                document.getElementById("video-frame").append(canvas);
                faceapi.matchDimensions(canvas, {
                    height: video.height,
                    width: video.width,
                });

                asyncRecursion(async () => {
                    canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);

                    const detections = await faceapi
                        .detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
                        .withFaceLandmarks();

                    const resizedDetections = faceapi.resizeResults(detections, {
                        height: video.height,
                        width: video.width,
                    });
                    // canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);
                    faceapi.draw.drawDetections(canvas, resizedDetections);
                    faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);

                    if (detections.length) {
                        const hidden_canvas = document.getElementById("hidden-canvas");
                        const ctx = hidden_canvas.getContext("2d");
                        hidden_canvas.width = video.videoWidth;
                        hidden_canvas.height = video.videoHeight;

                        ctx.drawImage(video, 0, 0, hidden_canvas.width, hidden_canvas.height);
                        pauseFaceRecognition();

                        await Swal.fire({
                            title: "Finding match from the database...",
                            showConfirmButton: false,
                            timer: 3000,
                        });

                        const imageData = hidden_canvas.toDataURL("image/png");
                        let response = await findFaceMatch(imageData);

                        if (response.status == 'success') {
                            await askPinNumber(response.patron);
                        } else {
                            await Swal.fire({
                                title: response.message,
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 3000,
                            });
                        }
                        stopFaceRecognition();
                    }
                });
            };

            async function askPinNumber(patron) {
                Swal.fire({
                    title: `Welcome! <span class="text-capitalize">${patron.name.toLowerCase()}</span>`,
                    html: `
                        <p><strong>Please enter your PIN: </strong></p>
                        <input
                            id="pin_number"
                            type="password"
                            class="form-control form-control-lg"
                            autocomplete="off"
                            autofocus="on"
                        />
                    `,
                    imageUrl: `/storage/images/users/${patron.details.profile}`,
                    imageWidth: 225,
                    imageHeight: 225,
                    imageAlt: 'User Profile',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    customClass: {
                        image: 'profile' // Apply a custom CSS class to the image
                    },
                    preConfirm: () => {
                        const inputValue = document.getElementById('pin_number').value;
                        return inputValue;
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (patron.pin != result.value) {
                            Swal.fire({
                                title: 'Incorrect PIN',
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 3000,
                            }).then(() => {
                                askPinNumber(patron);
                            });
                        } else {
                            recordAttendance(patron);
                        }
                    }
                });

                document.getElementById('pin_number').addEventListener('keydown', function(event) {
                    if (event.key === 'Enter') {
                        document.querySelector('.swal2-confirm').click(); // Trigger confirm button click
                    }
                });
            }

            async function recordAttendance(patron) {
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let formData  = new FormData();
                formData.set('card_number', patron.card_number);
                formData.set('name', patron.name);
                formData.set('role', patron.role);

                let response = await fetch('/services/attendance/record', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                });

                let { status, message } = await response.json();

                Swal.fire({
                    title: message,
                    icon: status,
                    showConfirmButton: false,
                    timer: 3000,
                }).then(() => {
                    window.location.reload();
                });
            }

            async function findBarcode(barcode) {
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let formData  = new FormData();
                    formData.set('barcode', barcode);

                let response = await fetch('/services/attendance/find_barcode', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                });

                let {
                    status,
                    message,
                    patron,
                } = await response.json();

                if (status == 'error') {
                    Swal.fire({
                        title: message,
                        icon: status,
                        showConfirmButton: false,
                        timer: 3000,
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    if (patron) {
                        askPinNumber(patron);
                    }
                }
            }

            window.addEventListener('load', async function() {
                let $barcode_reader = document.querySelector('#barcode_reader');

                $barcode_reader.onkeyup = async function(event) {
                    if (event.keyCode === 13 || event.keyCode === 9) {
                        let card_number = event.target.value.trim();

                        findBarcode(card_number);
                    }
                };

                video = document.querySelector('#video');
                await faceapi.nets.tinyFaceDetector.loadFromUri(`/models`),
                    await faceapi.nets.faceLandmark68Net.loadFromUri(`/models`),

                    video.addEventListener("play", handleVideo, false);
            });
        </script>
    </x-slot>
</x-layout>
