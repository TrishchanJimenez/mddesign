<?php
    session_start();
    $page_title = "Metro District Designs - Commissioned Designs";
    require_once "header.php";
    require_once "db_connection.php";
?>
<style>
    body {
        background-color: #E5E4E2;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    
    .navbar {
        background-color: #1E1E1E;
        padding: 10px 0;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        color: white !important;
        font-weight: bold;
    }

    .navbar-brand img {
        height: 30px;
        margin-right: 10px;
    }

    .navbar-nav {
        flex-grow: 1;
        justify-content: center;
    }

    .navbar-nav .nav-link {
        color: white !important;
        text-transform: uppercase;
        font-weight: bold;
        margin: 0 10px;
    }

    .navbar-nav.ms-auto {
        margin-right: 0 !important;
        align-items: center;
    }

    /* Search Bar Styles */
    .search-container {
        position: relative;
        margin-left: 15px;
    }

    .nav-icons {
        display: flex;
        align-items: center;
        color: white;
    }

    .nav-icons i {
        cursor: pointer;
        margin-left: 15px;
    }

    /* Search Popup Styles */
    .search-popup {
        position: absolute;
        top: 100%;
        right: 0;
        background-color: white;
        padding: 10px;
        border-radius: 4px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        display: none;
        width: 200px;
        z-index: 1000;
    }

    .search-popup input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .search-popup.active {
        display: block;
    }
    
    .container {
        width: 90%;
        max-width: 1200px;
        margin: 20px auto;
    }
    
    .commissioned-hero {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .commissioned-hero h1 {
        font-size: 32px;
        color: #333;
        text-transform: uppercase;
        margin-bottom: 5px;
    }
    
    .commissioned-hero p {
        font-style: italic;
        color: #666;
        margin-top: 5px;
    }
    
    .design-section {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .design-placeholder {
        background-color: #A99D9D;
        height: 450px;
        flex: 2;
        min-width: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .preview-section {
        flex: 1;
        min-width: 270px;
        display: flex;
        flex-direction: column;
    }
    
    .preview-placeholder {
        background-color: #A99D9D;
        height: 300px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .download-btn {
        background-color: #A99D9D;
        color: black;
        font-weight: bold;
        border: none;
        width: 100%;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.2s;
    }
    
    .download-btn:hover {
        background-color: #968888;
    }
    
    .tshirt-container {
        width: 270px;
        height: 320px;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .tshirt-image {
        width: 100%;
        height: auto;
    }
    
    .design-area {
        position: absolute;
        top: 33%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40%;
        height: 40%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #1a75bb;
        font-weight: bold;
        text-align: center;
        font-size: 14px;
    }
    
    .upload-placeholder {
        border: 2px dashed #1a75bb;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #1a75bb;
        font-weight: bold;
        text-align: center;
        font-size: 14px;
        padding: 5px;
    }
    
    .design-area img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    
    .upload-section {
        margin-top: 20px;
        display: flex;
        gap: 10px;
    }
    
    .file-input-container {
        position: relative;
        flex: 3;
    }
    
    .custom-file-input {
        width: 100%;
        padding: 8px;
        cursor: pointer;
        border: 1px solid #ccc;
        background-color: white;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }
    
    .upload-section input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .preview-btn {
        flex: 1;
        background-color: #888;
        color: white;
        border: none;
        padding: 8px;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .preview-btn:hover {
        background-color: #666;
    }
    
    .options-section {
        margin: 20px 0;
    }
    
    .option-title {
        font-weight: bold;
        margin-bottom: 10px;
    }
    
    .color-options {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }
    
    .color-option {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid #ccc;
        transition: border-color 0.2s;
    }
    
    .color-option.active {
        border: 2px solid #333;
    }
    
    .size-options {
        display: flex;
        gap: 10px;
    }
    
    .size-option {
        padding: 5px 15px;
        border: 1px solid #ccc;
        cursor: pointer;
        text-align: center;
        transition: all 0.2s;
    }
    
    .size-option.active {
        background-color: #333;
        color: white;
    }
    
    .design-controls {
        margin-top: 15px;
    }
    
    .slider-control {
        margin-bottom: 10px;
    }
    
    .slider-control label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        font-size: 14px;
    }
    
    .slider-control input {
        width: 100%;
    }

    /* Added styles for tab navigation */
    .custom-tabs {
        display: flex;
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
    }

    .custom-tab {
        padding: 10px 20px;
        cursor: pointer;
        border: 1px solid transparent;
        border-bottom: none;
        border-radius: 4px 4px 0 0;
        background-color: #f8f9fa;
        margin-right: 5px;
        font-weight: bold;
    }

    .custom-tab.active {
        background-color: #fff;
        border-color: #ddd;
        border-bottom-color: transparent;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Added styles from Inquiry page */
    #processing-canvas {
        display: none;
    }

    /* Login required modal */
    .login-modal {
        display: flex;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 1100;
        align-items: center;
        justify-content: center;
    }

    .login-modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        max-width: 400px;
        width: 90%;
        text-align: center;
    }

    .login-modal-content h3 {
        margin-top: 0;
    }

    .login-modal-buttons {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }

    /* Media queries for responsive design */
    @media (max-width: 768px) {
        .design-section {
            flex-direction: column;
        }
        
        .design-placeholder, .preview-section {
            width: 100%;
        }
    }
</style>
<body>
    <!-- Hidden canvas for image processing -->
    <canvas id="processing-canvas"></canvas>
    
    <!-- Navbar -->
    <?php require_once "navbar.php" ?>

    <!-- Login Required Modal -->
    <?php if(empty($_SESSION['user_id'])): ?>
        <div class="login-modal" id="loginModal">
            <div class="login-modal-content">
                <h3>Login Required</h3>
                <p>Please log in or create an account to submit a design inquiry.</p>
                <div class="login-modal-buttons">
                    <a href="Login.php" class="btn btn-primary">Login</a>
                    <a href="Signup.php" class="btn btn-secondary">Sign Up</a>
                    <button class="btn btn-outline-dark" id="cancelLoginBtn" onclick="location.href='index.php'">Cancel</button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php
        if(!empty($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $query = "
                SELECT
                    CONCAT(first_name, ' ', last_name) as full_name,
                    email,
                    contact_number
                FROM users
                WHERE id = ? 
            ";
        
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
        }
    ?>

    <div class="container">
        <div class="commissioned-hero">
            <h1>COMMISSIONED DESIGNS</h1>
            <p>"Looking for something unique? Get a custom design made just for you!"</p>
        </div>

        <!-- Tab Navigation -->
        <div class="custom-tabs">
            <div class="custom-tab active" data-tab="design-tab">Design Preview</div>
            <div class="custom-tab" data-tab="inquiry-tab">Submit Inquiry</div>
        </div>

        <!-- Design Preview Tab Content -->
        <div class="tab-content active" id="design-tab">
            <div class="design-section">
                <div class="design-placeholder">
                    <div class="tshirt-container" id="large-preview">
                        <svg class="tshirt-image" id="tshirt-svg-large" viewBox="0 0 200 220" xmlns="http://www.w3.org/2000/svg">
                            <!-- T-shirt shape -->
                            <path id="tshirt-body-large" d="M30,20 L60,5 L140,5 L170,20 L190,55 L170,70 L170,200 L30,200 L30,70 L10,55 Z" fill="white" />
                            
                            <!-- Collar -->
                            <path d="M60,5 L100,25 L140,5" fill="none" stroke="#ddd" stroke-width="1" />
                        </svg>
                        <div class="design-area" id="design-large">
                            <div class="upload-placeholder">
                                UPLOAD<br>YOUR<br>IMAGE<br>
                                <span style="font-size: 11px;">750x1200 px</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="preview-section">
                    <div class="preview-placeholder">
                        <div class="tshirt-container" id="small-preview">
                            <svg class="tshirt-image" id="tshirt-svg-small" viewBox="0 0 200 220" xmlns="http://www.w3.org/2000/svg">
                                <!-- T-shirt shape -->
                                <path id="tshirt-body-small" d="M30,20 L60,5 L140,5 L170,20 L190,55 L170,70 L170,200 L30,200 L30,70 L10,55 Z" fill="white" />
                                
                                <!-- Collar -->
                                <path d="M60,5 L100,25 L140,5" fill="none" stroke="#ddd" stroke-width="1" />
                            </svg>
                            <div class="design-area" id="design-small">
                                <div class="upload-placeholder">
                                    UPLOAD<br>YOUR<br>IMAGE<br>
                                    <span style="font-size: 10px;">750x1200 px</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="options-section">
                        <div class="option-title">Color</div>
                        <div class="color-options">
                            <div class="color-option active" style="background-color: white;" data-color="white"></div>
                            <div class="color-option" style="background-color: black;" data-color="black"></div>
                            <div class="color-option" style="background-color: #ff6b6b;" data-color="#ff6b6b"></div>
                            <div class="color-option" style="background-color: #4ecdc4;" data-color="#4ecdc4"></div>
                        </div>
                        
                        <div class="option-title">Size</div>
                        <div class="size-options">
                            <div class="size-option" data-size="S">S</div>
                            <div class="size-option active" data-size="M">M</div>
                            <div class="size-option" data-size="L">L</div>
                            <div class="size-option" data-size="XL">XL</div>
                        </div>
                        
                        <div class="design-controls" id="design-controls" style="display: none;">
                            <div class="option-title">Design Adjustments</div>
                            <div class="slider-control">
                                <label for="size-control">Size: <span id="size-value">100</span>%</label>
                                <input type="range" id="size-control" min="20" max="200" value="100">
                            </div>
                            <div class="slider-control">
                                <label for="position-y-control">Position Y: <span id="position-y-value">0</span>px</label>
                                <input type="range" id="position-y-control" min="-50" max="50" value="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="upload-section">
                        <div class="file-input-container">
                            <div class="custom-file-input" id="file-name">Choose File</div>
                            <input type="file" id="design-upload" accept="image/*">
                        </div>
                        <button class="preview-btn" id="preview-button">Preview</button>
                    </div>
                    
                    <button class="download-btn" id="download-button">Download</button>
                </div>
            </div>
        </div>

        <!-- Inquiry Form Tab Content -->
        <div class="tab-content" id="inquiry-tab">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Send Us Your Design Inquiry</h5>
                            <form id="inquiryForm" enctype="multipart/form-data" method="post" action="">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" value="<?php echo $user['full_name'] ?>" required readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" value="<?php echo $user['email'] ?>" required readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="phone" value="+63<?php echo $user['contact_number'] ?>" required readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="designType" class="form-label">Design Type</label>
                                    <select class="form-select" id="designType" name="designType" required>
                                        <option value="" selected disabled>Select a design type</option>
                                        <option value="tshirt">T-Shirt Design</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Design Description</label>
                                    <textarea class="form-control" id="description" rows="5" name="description" placeholder="Please provide as much detail as possible about your design needs..." required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="fileUpload" class="form-label">Reference Images (optional)</label>
                                    <input type="file" class="form-control" id="fileUpload" name="referenceImages[]" accept="image/*" multiple>
                                    <div class="form-text">Upload any reference images that might help us understand your vision.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="budget" class="form-label">Budget Range (PHP)</label>
                                    <select class="form-select" id="budget" name="budget" required>
                                        <option value="" selected disabled>Select your budget range</option>
                                        <option value="Under ₱100">Under ₱100</option>
                                        <option value="₱100-₱200">₱100 - ₱200</option>
                                        <option value="₱200-₱500">₱200 - ₱500</option>
                                        <option value="Over ₱500">Over ₱500</option>
                                        <option value="flexible">Flexible/Not Sure</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="timeline" class="form-label">Timeline</label>
                                    <select class="form-select" id="timeline" name="timeline" required>
                                        <option value="" selected disabled>When do you need this by?</option>
                                        <option value="urgent">ASAP (1-3 days)</option>
                                        <option value="standard">Standard (1-2 weeks)</option>
                                        <option value="relaxed">No Rush (2+ weeks)</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-dark w-100">Submit Inquiry</button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Our Design Process</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <span class="badge bg-dark rounded-circle p-2">1</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Initial Consultation</h6>
                                            <p class="mb-0 text-muted">We'll discuss your needs and provide a quote.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <span class="badge bg-dark rounded-circle p-2">2</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Concept Development</h6>
                                            <p class="mb-0 text-muted">We'll create initial design concepts based on your requirements.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <span class="badge bg-dark rounded-circle p-2">3</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Revisions</h6>
                                            <p class="mb-0 text-muted">We'll refine the designs based on your feedback.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <span class="badge bg-dark rounded-circle p-2">4</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Final Approval</h6>
                                            <p class="mb-0 text-muted">You'll review and approve the final design.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <span class="badge bg-dark rounded-circle p-2">5</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Delivery</h6>
                                            <p class="mb-0 text-muted">We'll deliver the final files in your preferred format.</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            
                            <div class="mt-4 p-3 bg-light rounded">
                                <h6>Have Questions?</h6>
                                <p class="mb-2">Contact us directly:</p>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-envelope me-2"></i>
                                    <a href="mailto:sjbps_10@yahoo.com" style="color: black; text-decoration: none;">sjbps_10@yahoo.com</a>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-telephone me-2"></i>
                                    <p class="mb-0"><a href="tel:+63282965896" style="color: black; text-decoration: none;">(+632) 8296-5896</a> | <a href="tel:+639201225764" style="color: black; text-decoration: none;">0920 122 5764</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab navigation
            const tabs = document.querySelectorAll('.custom-tab');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    tabs.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked tab
                    tab.classList.add('active');
                    
                    // Hide all tab contents
                    tabContents.forEach(content => content.classList.remove('active'));
                    // Show the corresponding tab content
                    const tabId = tab.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });

            // Search functionality
            const searchToggle = document.getElementById('searchToggle');
            const searchPopup = document.getElementById('searchPopup');
            const searchInput = document.getElementById('searchInput');

            searchToggle.addEventListener('click', function() {
                searchPopup.classList.toggle('active');
                if (searchPopup.classList.contains('active')) {
                    searchInput.focus();
                }
            });

            // Close search popup when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.search-container') && searchPopup.classList.contains('active')) {
                    searchPopup.classList.remove('active');
                }
            });

            // T-shirt designer functionality
            const designUpload = document.getElementById('design-upload');
            const designLarge = document.getElementById('design-large');
            const designSmall = document.getElementById('design-small');
            const fileNameDisplay = document.getElementById('file-name');
            const previewButton = document.getElementById('preview-button');
            const downloadButton = document.getElementById('download-button');
            const designControls = document.getElementById('design-controls');
            const sizeControl = document.getElementById('size-control');
            const positionYControl = document.getElementById('position-y-control');
            const sizeValue = document.getElementById('size-value');
            const positionYValue = document.getElementById('position-y-value');
            const tshirtBodyLarge = document.getElementById('tshirt-body-large');
            const tshirtBodySmall = document.getElementById('tshirt-body-small');
            const processingCanvas = document.getElementById('processing-canvas');
            const ctx = processingCanvas.getContext('2d');
            
            // Variables to store design state
            let designImage = null;
            let currentColor = 'white';
            let currentSize = 'M';
            let designScale = 100;
            let designPositionY = 0;
            let hasUploadedDesign = false;

            // Update T-shirt color
            document.querySelectorAll('.color-option').forEach(option => {
                option.addEventListener('click', function() {
                    // Remove active class from all options
                    document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('active'));
                    // Add active class to clicked option
                    option.classList.add('active');
                    
                    // Update T-shirt color
                    currentColor = option.getAttribute('data-color');
                    tshirtBodyLarge.setAttribute('fill', currentColor);
                    tshirtBodySmall.setAttribute('fill', currentColor);
                });
            });

            // Update T-shirt size
            document.querySelectorAll('.size-option').forEach(option => {
                option.addEventListener('click', function() {
                    // Remove active class from all options
                    document.querySelectorAll('.size-option').forEach(opt => opt.classList.remove('active'));
                    // Add active class to clicked option
                    option.classList.add('active');
                    
                    // Update T-shirt size
                    currentSize = option.getAttribute('data-size');
                });
            });

            // Handle file upload
            designUpload.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    fileNameDisplay.textContent = file.name;
                    
                    // Read the uploaded file
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Store the image for preview
                        designImage = new Image();
                        designImage.onload = function() {
                            hasUploadedDesign = true;
                        };
                        designImage.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Preview button functionality
            previewButton.addEventListener('click', function() {
                if (designImage) {
                    // Remove placeholder
                    designLarge.innerHTML = '';
                    designSmall.innerHTML = '';
                    
                    // Create img elements
                    const imgLarge = document.createElement('img');
                    imgLarge.src = designImage.src;
                    imgLarge.style.maxWidth = '100%';
                    imgLarge.style.maxHeight = '100%';
                    designLarge.appendChild(imgLarge);
                    
                    const imgSmall = document.createElement('img');
                    imgSmall.src = designImage.src;
                    imgSmall.style.maxWidth = '100%';
                    imgSmall.style.maxHeight = '100%';
                    designSmall.appendChild(imgSmall);
                    
                    // Show design controls
                    designControls.style.display = 'block';
                    
                    // Apply initial styles
                    updateDesignStyles();
                } else {
                    alert('Please upload an image first.');
                }
            });

            // Update design styles based on control values
            function updateDesignStyles() {
                // Skip if no design is loaded
                if (!hasUploadedDesign) return;
                
                const scalePercent = parseInt(sizeControl.value) / 100;
                const yOffset = parseInt(positionYControl.value);
                
                // Update value displays
                sizeValue.textContent = sizeControl.value;
                positionYValue.textContent = positionYControl.value;
                
                // Apply to large preview
                const imgLarge = designLarge.querySelector('img');
                if (imgLarge) {
                    imgLarge.style.transform = `scale(${scalePercent}) translateY(${yOffset}px)`;
                }
                
                // Apply to small preview
                const imgSmall = designSmall.querySelector('img');
                if (imgSmall) {
                    imgSmall.style.transform = `scale(${scalePercent}) translateY(${yOffset}px)`;
                }
                
                // Store current values
                designScale = parseInt(sizeControl.value);
                designPositionY = yOffset;
            }

            // Add event listeners for design controls
            sizeControl.addEventListener('input', updateDesignStyles);
            positionYControl.addEventListener('input', updateDesignStyles);

            // Download button functionality
            downloadButton.addEventListener('click', function() {
                if (!hasUploadedDesign) {
                    alert('Please upload and preview a design first.');
                    return;
                }
                
                // Set canvas dimensions
                processingCanvas.width = 800;
                processingCanvas.height = 1000;
                
                // Draw t-shirt background
                ctx.fillStyle = currentColor;
                ctx.beginPath();
                ctx.moveTo(120, 80);
                ctx.lineTo(240, 20);
                ctx.lineTo(560, 20);
                ctx.lineTo(680, 80);
                ctx.lineTo(760, 220);
                ctx.lineTo(680, 280);
                ctx.lineTo(680, 800);
                ctx.lineTo(120, 800);
                ctx.lineTo(120, 280);
                ctx.lineTo(40, 220);
                ctx.closePath();
                ctx.fill();
                
                // Draw collar
                ctx.strokeStyle = '#ddd';
                ctx.lineWidth = 2;
                ctx.beginPath();
                ctx.moveTo(240, 20);
                ctx.lineTo(400, 100);
                ctx.lineTo(560, 20);
                ctx.stroke();
                
                // Calculate design position and size
                const scalePercent = designScale / 100;
                const designWidth = designImage.width * scalePercent;
                const designHeight = designImage.height * scalePercent;
                const designX = (processingCanvas.width - designWidth) / 2;
                const designY = 160 + designPositionY;
                
                // Draw the design
                ctx.drawImage(
                    designImage, 
                    designX, 
                    designY, 
                    designWidth, 
                    designHeight
                );
                
                // Convert canvas to image and download
                const downloadLink = document.createElement('a');
                downloadLink.href = processingCanvas.toDataURL('image/png');
                downloadLink.download = 'metro-district-tshirt-design.png';
                downloadLink.click();
            });

            const inquiryForm = document.getElementById('inquiryForm');

            inquiryForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Collect form data
                const formData = new FormData(inquiryForm);

                try {
                    const response = await fetch('api/submit_inquiry.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (response.ok) {
                        alert('Your design inquiry has been submitted! We will contact you as soon as we can.');
                        inquiryForm.reset();
                    } else {
                        alert(result.error || 'An error occurred while submitting your inquiry.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                }
            });
        });
    </script>
</body>
</html>