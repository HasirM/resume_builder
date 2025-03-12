<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Save resume data to the database
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $aboutme = $_POST['aboutme'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $website = $_POST['website'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];

    $sql = "INSERT INTO resumes (user_id, fname, lname, aboutme, phone, email, website, address, pincode)
            VALUES ('$user_id', '$fname', '$lname', '$aboutme', '$phone', '$email', '$website', '$address', '$pincode')";

    if ($conn->query($sql) === TRUE) {
        echo "Resume saved successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Builder</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style1.css">
</head>

<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <div>Resume Builder</div>
        <div class="profile-dropdown">
            <a href="#"><i class="fas fa-bars"></i></a>            <div class="profile-dropdown-content">
                <a href="profile.php">Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Message Window -->
        <div class="message-window" id="message-window">
            <span class="close-btn" id="close-btn">&times;</span>
            <p>Please complete your <a href="profile.php">profile creation</a> to proceed. If completed, ignore this message.</p>
        </div>

        <!-- Resume Templates Section -->
        <div class="templates-section">
            <h2>Resume Templates</h2>
            <div class="template-grid">
                <!-- Template 1 -->
                <div class="template-card" onclick="showButtons(this)">
                    <img src="uploads/templates/1.webp" alt="Template 1">
                    <div class="overlay">
                        <div class="overlay-text" onclick="openModal('uploads/templates/1.webp')">
                            <i class="fas fa-user"></i> Preview
                        </div>
                        <div class="overlay-text" onclick="window.location.href='download_pdf.php?template=1';">
                            <i class="fas fa-cog"></i> Generate
                        </div>
                    </div>
                </div>
                <!-- Template 2 -->
                <div class="template-card" onclick="showButtons(this)">
                    <img src="uploads/templates/2.webp" alt="Template 2">
                    <div class="overlay">
                        <div class="overlay-text" onclick="openModal('uploads/templates/2.webp')">
                            <i class="fas fa-eye"></i> Preview
                        </div>
                        <div class="overlay-text" onclick="window.location.href='download_pdf.php?template=2';">
                            <i class="fas fa-cog"></i> Generate
                        </div>
                    </div>
                </div>
                <!-- Template 3 -->
                <div class="template-card" onclick="showButtons(this)">
                    <img src="uploads/templates/3.webp" alt="Template 3">
                    <div class="overlay">
                        <div class="overlay-text" onclick="openModal('uploads/templates/3.webp')">
                            <i class="fas fa-eye"></i> Preview
                        </div>
                        <div class="overlay-text" onclick="window.location.href='download_pdf.php?template=3';">
                            <i class="fas fa-cog"></i> Generate
                        </div>
                    </div>
                </div>
                <!-- Template 4 -->
                <div class="template-card" onclick="showButtons(this)">
                    <img src="uploads/templates/4.webp" alt="Template 4">
                    <div class="overlay">
                        <div class="overlay-text" onclick="openModal('uploads/templates/4.webp')">
                            <i class="fas fa-eye"></i> Preview
                        </div>
                        <div class="overlay-text" onclick="window.location.href='download_pdf.php?template=4';">
                            <i class="fas fa-cog"></i> Generate
                        </div>
                    </div>
                </div>
                <!-- Template 5 -->
                <div class="template-card" onclick="showButtons(this)">
                    <img src="uploads/templates/5.webp" alt="Template 5">
                    <div class="overlay">
                        <div class="overlay-text" onclick="openModal('uploads/templates/5.webp')">
                            <i class="fas fa-eye"></i> Preview
                        </div>
                        <div class="overlay-text" onclick="window.location.href='download_pdf.php?template=5';">
                            <i class="fas fa-cog"></i> Generate
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popup Modal -->
    <div class="modal" id="previewModal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <img id="modalImage" src="" alt="Preview Image">
        </div>
    </div>

    <script>
        // Function to open the modal with the image
        function openModal(imageSrc) {
            const modal = document.getElementById('previewModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageSrc;
            modal.style.display = 'flex';
        }

        // Function to close the modal
        function closeModal() {
            const modal = document.getElementById('previewModal');
            modal.style.display = 'none';
            document.getElementById('modalImage').src = '';
        }

        // Function to show buttons on mobile
        function showButtons(card) {
            if (window.innerWidth <= 768) {
                // Remove active class from all cards
                document.querySelectorAll('.template-card').forEach(c => c.classList.remove('active'));
                // Add active class to the clicked card
                card.classList.add('active');
            }
        }

        // Close message window
        document.getElementById('close-btn').addEventListener('click', function() {
            const messagebox = document.getElementById('message-window');
            messagebox.style.display = 'none';
        });

        // Close modal when clicking outside the content
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('previewModal');
            if (event.target === modal) {
                closeModal();
            }
        });
    </script>
</body>

</html>