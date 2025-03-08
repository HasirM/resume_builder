<?php session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Resume</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
            overflow-x: hidden;
        }

        /* Navigation Bar */
        .navbar {
            background-color: #2c3e50;
            font-family: 'poppins';
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            grid-area: 20px;
        }

        .navbar a {
            text-decoration: none;
            color: white;
            margin: 0 15px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .navbar a:hover {
            color: #1abc9c;
        }

        i.fas.fa-bars {
            font-size: 26px;
        }





        .profile-dropdown {
            position: relative;
        }

        .profile-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #fff;
            min-width: 160px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            z-index: 1000;
        }

        .profile-dropdown-content a {
            color: #333;
            padding: 12px 16px;
            display: block;
            transition: background-color 0.3s ease;
        }

        .profile-dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .profile-dropdown:hover .profile-dropdown-content {
            display: block;
        }

        .download-btn {
            background-color: #1abc9c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-family: 'Poppins';
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .download-btn:hover {
            background-color: #16a085;
        }

        .download-btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        /* A4 Container */
        .a4-container {
            max-width: 794px;
            margin: 100px auto 2rem;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            width: 90%;
            padding: 20px;
        }

        /* Hidden Container for Template Injection */
        .hidden {
            position: fixed;
            top: -9999px;
            left: -9999px;
        }

        /* Loading Popup */
        .loading-popup {
            display: none;
            font-family: 'poppins';
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 2000;
            text-align: center;
        }

        .loading-popup .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #ccc;
            border-top: 5px solid #1abc9c;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }

        .loading-popup .text {
            font-size: 16px;
            font-weight: 500;
            color: #333;
        }



        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <div><a href="index.php">Home</a></div>
        <div class="navbar-right">
            <button id="downloadBtn" class="download-btn">Download PDF</button>
            <div class="profile-dropdown">
                <a href="#"><i class="fas fa-bars"></i></a>
                <div class="profile-dropdown-content">
                    <a href="profile.php">Profile</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Popup -->
    <div class="loading-popup" id="loadingPopup">
        <div class="spinner"></div>
        <div class="text" id="loadingText">Generating PDF...</div>
    </div>
    <a href="index.php">Back to Templates</a>

    <!-- A4 Container for Displaying the Resume -->
    <div class="a4-container" id="a4Container"></div>

    <!-- Hidden Container for Template Injection -->
    <div class="container hidden" id="resume"></div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        // Function to show loading popup
        function showLoadingPopup(text) {
            const loadingPopup = document.getElementById('loadingPopup');
            const loadingText = document.getElementById('loadingText');
            const downloadBtn = document.getElementById('downloadBtn');

            loadingText.textContent = text;
            loadingPopup.style.display = 'block';
            downloadBtn.disabled = true; // Disable the download button
        }

        // Function to hide loading popup
        function hideLoadingPopup() {
            const loadingPopup = document.getElementById('loadingPopup');
            const downloadBtn = document.getElementById('downloadBtn');

            loadingPopup.style.display = 'none';
            downloadBtn.disabled = false; // Enable the download button
        }

        // Function to load the template
        async function loadTemplate() {
            showLoadingPopup('Generating Resume...');
            const urlParams = new URLSearchParams(window.location.search);
            const templateId = urlParams.get('template') || '1';
            try {
                const response = await fetch(`templates/resume${templateId}.php`);
                if (!response.ok) throw new Error('Failed to fetch template');
                const data = await response.text();
                document.getElementById('resume').innerHTML = data;
                await generateImage();
            } catch (error) {
                console.error('Fetch error:', error);
                alert('Error loading template. Please try again.');
            } finally {
                hideLoadingPopup();
            }
        }

        // Function to generate the image
        async function generateImage() {
            const resume = document.getElementById('resume');
            const a4Container = document.getElementById('a4Container');
            const options = {
                scale: 3,
                useCORS: true,
                logging: false
            };

            try {
                const canvas = await html2canvas(resume, options);
                const image = canvas.toDataURL('image/png', 1.0);
                const img = new Image();
                img.src = image;
                img.style.width = '100%';
                a4Container.innerHTML = '';
                a4Container.appendChild(img);
            } catch (error) {
                console.error('Image generation error:', error);
            }
        }

        // Function to generate the PDF
        async function generatePDF() {
            const downloadBtn = document.getElementById('downloadBtn');

            // Disable the button immediately
            downloadBtn.disabled = true;
            showLoadingPopup('Downloading PDF...');

            const marginLeftRight = 0; // Left and Right Margin
            const marginTop = 0; // Top Margin (set to 0 to start from the top)

            const resume = document.getElementById('resume');
            const pdf = new jspdf.jsPDF({
                orientation: 'portrait',
                unit: 'mm',
                format: 'a4'
            });
            const pageHeight = 297; // A4 Page Height in mm
            const pageWidth = 210; // A4 Width in mm
            const usableWidth = pageWidth - (2 * marginLeftRight);

            try {
                const canvas = await html2canvas(resume, {
                    scale: 4,
                    useCORS: true
                }); // Scale set to 4
                const imgData = canvas.toDataURL('image/jpeg', 1.0); // JPEG format with 100% quality
                const imgHeight = (canvas.height * usableWidth) / canvas.width; // Maintain Aspect Ratio

                let yOffset = 0;
                let currentHeight = imgHeight;
                const sliceHeight = (pageHeight * canvas.width) / pageWidth; // Height slice in canvas units
                let isContentAdded = false; // Flag to check if content is added

                // Loop to split the canvas into pages
                while (currentHeight > 0) {
                    const tempCanvas = document.createElement('canvas');
                    tempCanvas.width = canvas.width;
                    tempCanvas.height = Math.min(sliceHeight, canvas.height - yOffset);
                    const ctx = tempCanvas.getContext('2d');

                    ctx.drawImage(canvas, 0, yOffset, canvas.width, tempCanvas.height, 0, 0, canvas.width, tempCanvas.height);
                    const partImg = tempCanvas.toDataURL('image/jpeg', 1.0); // Apply compression on each slice

                    const verticalOffset = marginTop; // Always start from the top (0 margin)

                    pdf.addImage(partImg, 'JPEG', marginLeftRight, verticalOffset, usableWidth, (tempCanvas.height * usableWidth) / canvas.width);
                    isContentAdded = true; // Mark content as added

                    yOffset += tempCanvas.height;
                    currentHeight -= (tempCanvas.height * usableWidth) / canvas.width;

                    if (currentHeight > 0) {
                        pdf.addPage();
                    }
                }

                // Remove the last empty page only if no content was added
                if (pdf.internal.getNumberOfPages() > 1 && !isContentAdded) {
                    pdf.deletePage(pdf.internal.getNumberOfPages());
                }

                pdf.save('resume.pdf');
                //console.log('PDF generated successfully with compression and separate margins');
            } catch (error) {
                console.error('PDF generation failed:', error);
                alert('Failed to generate PDF. Please try again.');
            } finally {
                hideLoadingPopup();
            }
        }

        // Event Listeners
        document.getElementById('downloadBtn').addEventListener('click', function() {
            const loadingPopup = document.getElementById('loadingPopup');

            // Check if the loading popup is visible (display is set to 'block')
            if (loadingPopup.style.display === 'none') {
                //console.log("Loading popup is not vivible,");

                generatePDF();

            }

            // If the popup is not visible, run the generatePDF function
        });

        document.addEventListener('DOMContentLoaded', loadTemplate);
    </script>
</body>

</html>