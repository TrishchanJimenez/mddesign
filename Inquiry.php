<?php
    session_start();
    $page_title = "Metro District Designs - Design Inquiry";
    require_once "header.php";
    require_once "db_connection.php";
    require_once "chat-box.php";
?>
<style>
    body {
        background-color: #E5E4E2;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .inquiry-hero {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .inquiry-hero h1 {
        font-size: 32px;
        color: #333;
        text-transform: uppercase;
        margin-bottom: 5px;
    }
    
    .inquiry-hero p {
        font-style: italic;
        color: #666;
        margin-top: 5px;
    }
    
    .design-section {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .design-preview {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 20px;
        flex: 2;
        min-width: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    
    .settings-section {
        flex: 1;
        min-width: 270px;
        display: flex;
        flex-direction: column;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 20px;
    }
    
    .price-display-container {
        margin: 15px 0;
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
    }
    
    .submit-btn {
        background-color: #4CAF50;
        color: white;
        font-weight: bold;
        border: none;
        width: 100%;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.2s;
        border-radius: 4px;
    }
    
    .submit-btn:hover {
        background-color: #45a049;
    }
    
    .tshirt-container {
        width: 500px;
        height: 600px;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto;
    }
    
    .tshirt-image {
        width: 150%;
        height: auto;
    }
    
    .design-area {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -55%);
        width: 240px;
        height: 240px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: rgba(255, 255, 255, 0.1);
    }

    .design-safety {
        position: absolute;
        width: 90%;
        height: 90%;
        border: 2px dashed #0f0;
        pointer-events: none;
    }

    .design-bleed {
        position: absolute;
        width: 105%;
        height: 105%;
        border: 2px dashed #00f;
        pointer-events: none;
    }
    
    .design-labels {
        position: absolute;
        top: -35px;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        display: flex;
        justify-content: space-around;
        pointer-events: none;
    }

    .design-label {
        background-color: #fff;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: bold;
        border: 1px solid #ccc;
    }
    
    .design-area img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    
    .upload-placeholder {
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
        margin-bottom: 15px;
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
    
    .slider-control label, .quantity-control label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        font-size: 14px;
    }
    
    .slider-control input, .quantity-control input {
        width: 100%;
    }
    
    .quantity-control {
        margin: 10px 0 15px 0;
    }

    /* Styles for tab navigation */
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

    /* Canvas for image processing */
    #processing-canvas {
        display: none;
        position: absolute;
        left: -9999px;
    }

    /* Instructions box */
    .instructions-box {
        background-color: #f8f9fa;
        border-left: 4px solid #1a75bb;
        padding: 15px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .instructions-box h4 {
        margin-top: 0;
        color: #1a75bb;
    }

    .instructions-box ul {
        padding-left: 20px;
        margin-bottom: 0;
    }

    /* Dimension labels */
    .dimension-label {
        position: absolute;
        color: #666;
        font-size: 12px;
        font-weight: bold;
        pointer-events: none;
    }

    .dimension-label.width {
        bottom: 5px;
        left: 50%;
        transform: translateX(-50%);
    }

    .dimension-label.height {
        right: 5px;
        top: 50%;
        transform: translateY(-50%) rotate(90deg);
    }

    /* Login Required Modal */
    .login-modal {
        display: none;
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
        
        .design-preview, .settings-section {
            width: 100%;
        }

        .tshirt-container {
            width: 300px;
            height: 350px;
        }
        
        .design-area {
            width: 140px;
            height: 140px;
        }
    }

    /* Error message for design overlapping */
    .design-error {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
        display: none;
    }
</style>

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
    <div class="inquiry-hero">
        <h1>DESIGN INQUIRY FORM</h1>
        <p>"Let us bring your creative vision to life!"</p>
    </div>

    <!-- Instructions Box -->
    <div class="instructions-box">
        <h4>How to Create Your Design Inquiry</h4>
        <ul>
            <li>Upload your reference image or design concept</li>
            <li>Adjust the design placement and size</li>
            <li>Choose your preferred t-shirt color and size</li>
            <li>Complete the inquiry form with your specific requirements</li>
            <li>Submit your inquiry and we'll get back to you soon!</li>
        </ul>
    </div>

    <!-- Tab Navigation -->
    <div class="custom-tabs">
        <div class="custom-tab active" data-tab="design-tab">Design Preview</div>
        <div class="custom-tab" data-tab="inquiry-tab">Your Information</div>
    </div>

    <!-- Design Preview Tab Content -->
    <div class="tab-content active" id="design-tab">
        <div class="design-section">
            <div class="design-preview">
                <div class="tshirt-container" id="main-preview">
                    <img src="s_4s__BOXY-FRONT.jpg" alt="T-Shirt Template" class="tshirt-image">
                    <div class="design-area" id="design-area">
                        <div class="design-safety"></div>
                        <div class="design-bleed"></div>
                        <div class="design-labels">
                            <span class="design-label">Safety Area</span>
                            <span class="design-label">Bleed</span>
                        </div>
                        <div class="upload-placeholder">
                            UPLOAD<br>YOUR<br>DESIGN<br>
                            <span style="font-size: 11px;">750x1200 px recommended</span>
                        </div>
                    </div>
                    <div class="dimension-label width">12in</div>
                    <div class="dimension-label height">12in</div>
                </div>
                
                <div class="upload-section">
                    <div class="file-input-container">
                        <div class="custom-file-input" id="file-name">Choose File</div>
                        <input type="file" id="design-upload" accept="image/*">
                    </div>
                    <button class="preview-btn" id="preview-button">Preview</button>
                </div>
                <div class="design-error" id="design-error">Warning: Design is exceeding the allowed area. Please adjust size or position.</div>
            </div>
            
            <div class="settings-section">
                <div class="price-display-container">
                    <h3>Estimated Price: <span id="price-display">₱300.00</span></h3>
                </div>
                
                <div class="options-section">
                    <div class="option-title">T-Shirt Color</div>
                    <div class="color-options">
                        <div class="color-option" style="background-color: white;" data-color="#ffffff"></div>
                        <div class="color-option active" style="background-color: black;" data-color="#000000"></div>
                        <div class="color-option" style="background-color: #ff6b6b;" data-color="#ff6b6b"></div>
                        <div class="color-option" style="background-color: #4ecdc4;" data-color="#4ecdc4"></div>
                        <div class="color-option" style="background-color: #f9dc5c;" data-color="#f9dc5c"></div>
                        <div class="color-option" style="background-color: #3d5a80;" data-color="#3d5a80"></div>
                    </div>
                    
                    <div class="option-title">Size</div>
                    <div class="size-options">
                        <div class="size-option" data-size="S">S</div>
                        <div class="size-option active" data-size="M">M</div>
                        <div class="size-option" data-size="L">L</div>
                        <div class="size-option" data-size="XL">XL</div>
                        <div class="size-option" data-size="XXL">XXL</div>
                    </div>
                    
                    <div class="option-title">Quantity</div>
                    <div class="quantity-control">
                        <div class="slider-control">
                        <label for="quantity-control">
                            Quantity:
                            <input type="number" id="quantity-input" min="1" max="50" value="1" style="width: 60px; display: inline-block; margin: 0 5px;">
                        </label>
                        <input type="range" id="quantity-control" min="1" max="50" value="1" style="width: 100%;">
                        </div>
                    </div>
                    <div class="design-controls" id="design-controls" style="display: none;">
                        <div class="option-title">Design Adjustments</div>
                        <div class="slider-control">
                            <label for="size-control">
                            Size:
                            <input type="number" id="size-input" min="20" max="200" value="100" style="width: 60px; display: inline-block; margin: 0 5px;">
                            %
                            </label>
                            <input type="range" id="size-control" min="20" max="200" value="100" style="width: 100%;">
                        </div>
                        <div class="slider-control">
                            <label for="position-y-control">
                                Position Y:
                                <input type="number" id="position-y-input" min="-50" max="50" value="0" style="width: 60px; display: inline-block; margin: 0 5px;">
                                px
                            </label>
                            <input type="range" id="position-y-control" min="-50" max="50" value="0" style="width: 100%;">
                        </div>
                        <div class="slider-control">
                            <label for="position-x-control">
                                Position X:
                                <input type="number" id="position-x-input" min="-50" max="50" value="0" style="width: 60px; display: inline-block; margin: 0 5px;">
                                px
                            </label>
                            <input type="range" id="position-x-control" min="-50" max="50" value="0" style="width: 100%;">
                        </div>
                    </div>
                </div>
                <button class="submit-btn" id="next-btn">Next: Your Information</button>
            </div>
        </div>
    </div>

    <!-- Inquiry Form Tab Content -->
    <div class="tab-content" id="inquiry-tab">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Your Design Inquiry Details</h5>
                        <form id="inquiryForm" enctype="multipart/form-data" method="post" action="api/submit_inquiry.php">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($user['full_name']) ? $user['full_name'] : ''; ?>" required <?php echo isset($user['full_name']) ? 'readonly' : ''; ?>>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>" required <?php echo isset($user['email']) ? 'readonly' : ''; ?>>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Contact Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo isset($user['contact_number']) ? '+63' . $user['contact_number'] : ''; ?>" required <?php echo isset($user['contact_number']) ? 'readonly' : ''; ?>>
                            </div>
                            
                            <!-- Hidden fields to store design details -->
                            <input type="hidden" id="design-color" name="color" value="000000">
                            <input type="hidden" id="design-size" name="size" value="M">
                            <input type="hidden" id="design-quantity" name="quantity" value="1">
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Design Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5" placeholder="Please describe your design idea, including any specific colors, elements, styles, or themes you'd like to incorporate..." required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="timeline" class="form-label">When do you need this by?</label>
                                <select class="form-select" id="timeline" name="timeline" required>
                                    <option value="" selected disabled>Select a timeframe</option>
                                    <option value="urgent">ASAP (1-3 days)</option>
                                    <option value="standard">Standard (1-2 weeks)</option>
                                    <option value="relaxed">No Rush (2+ weeks)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="additional_info" class="form-label">Additional Information (Optional)</label>
                                <textarea class="form-control" id="additional_info" name="additional_info" rows="3" placeholder="Any other details or special requirements..."></textarea>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-dark" id="back-to-design">Back to Design</button>
                                <button type="submit" class="btn btn-success" id="submit-inquiry">Submit Inquiry</button>
                            </div>
                            <input type="hidden" id="referenceImage" name="referenceImage">
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Design Summary</h5>
                        <div class="text-center mb-3">
                            <div class="tshirt-container" style="width: 200px; height: 230px; position: relative;" id="summary-preview">
                                <img src="s_4s__BOXY-FRONT.jpg" alt="T-Shirt Template" class="tshirt-image" style="width: 100%; height: 100%; object-fit: contain;">
                                <div class="design-area" id="summary-design-area" style="width: 45%; height: 45%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -55%);">
                                    <div class="upload-placeholder" style="font-size: 12px;">
                                        YOUR<br>DESIGN
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-6 text-end fw-bold">Design Type:</div>
                            <div class="col-6" id="summary-type">T-Shirt</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6 text-end fw-bold">Color:</div>
                            <div class="col-6" id="summary-color">Black</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6 text-end fw-bold">Size:</div>
                            <div class="col-6" id="summary-size">M</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6 text-end fw-bold">Quantity:</div>
                            <div class="col-6" id="summary-quantity">1</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6 text-end fw-bold">Estimated Price:</div>
                            <div class="col-6 fw-bold" id="summary-price">₱300.00</div>
                        </div>
                        
                        <div class="alert alert-info mt-4">
                            <h6 class="mb-2">What happens next?</h6>
                            <ol class="mb-0">
                                <li>We'll review your inquiry within 24-48 hours</li>
                                <li>Our design team will contact you to discuss details</li>
                                <li>We'll provide a final quote based on your requirements</li>
                                <li>Once approved, we'll begin creating your custom design</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab navigation
        const tabs = document.querySelectorAll('.custom-tab');
        const tabContents = document.querySelectorAll('.tab-content');
        
        function switchTab(tabId) {
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));
            // Add active class to the specified tab
            tabs.forEach(t => {
                if (t.getAttribute('data-tab') === tabId) {
                    t.classList.add('active');
                }
            });
            
            // Hide all tab contents
            tabContents.forEach(content => content.classList.remove('active'));
            // Show the corresponding tab content
            document.getElementById(tabId).classList.add('active');
        }
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const tabId = tab.getAttribute('data-tab');
                switchTab(tabId);
            });
        });

        // Next button click handler
        document.getElementById('next-btn').addEventListener('click', function() {
            // Check if design is within bounds
            if (isDesignOutOfBounds()) {
                alert("Your design is exceeding the allowed area. Please adjust the size or position.");
                return;
            }
            
            // Check if logged in
            <?php if(empty($_SESSION['user_id'])): ?>
                // Show login modal
                document.getElementById('loginModal').style.display = 'flex';
                return;
            <?php endif; ?>
            
            // Switch to inquiry tab
            switchTab('inquiry-tab');
            
            // Update summary with current values
            updateSummary();
        });
        
        // Back to design button click handler
        document.getElementById('back-to-design').addEventListener('click', function() {
            switchTab('design-tab');
        });

        // T-shirt designer functionality
        const designUpload = document.getElementById('design-upload');
        const designArea = document.getElementById('design-area');
        const summaryDesignArea = document.getElementById('summary-design-area');
        const fileNameDisplay = document.getElementById('file-name');
        const previewButton = document.getElementById('preview-button');
        const designControls = document.getElementById('design-controls');
        const sizeControl = document.getElementById('size-control');
        const positionYControl = document.getElementById('position-y-control');
        const positionXControl = document.getElementById('position-x-control');
        const quantityControl = document.getElementById('quantity-control');
        const sizeInput = document.getElementById('size-input');
        const positionYInput = document.getElementById('position-y-input');
        const positionXInput = document.getElementById('position-x-input');
        const quantityInput = document.getElementById('quantity-input');
        const processingCanvas = document.getElementById('processing-canvas');
        const ctx = processingCanvas.getContext('2d');
        const priceDisplay = document.getElementById('price-display');
        const summaryPrice = document.getElementById('summary-price');
        const designError = document.getElementById('design-error');
        const summaryTshirtBody = document.getElementById('summary-tshirt-body');
        
        // Variables to store design state
        let designImage = null;
        let processedImage = null;
        let currentColor = '#000000';
        let currentSize = 'M';
        let designScale = 100;
        let designXPosition = 0;
        let designYPosition = 0;
        let currentQuantity = 1;
        let basePrice = 300;
        
        // Function to check if design is out of bounds
        function isDesignOutOfBounds() {
    if (!designImage) return false;
    
    const img = designArea.querySelector('img');
    if (!img) return false;
    
    // Get the bounding rectangles
    const designAreaRect = designArea.getBoundingClientRect();
    const safetyAreaRect = designArea.querySelector('.design-safety').getBoundingClientRect();
    const imgRect = img.getBoundingClientRect();
    
    // Check if image exceeds the design area
    if (imgRect.left < designAreaRect.left || 
        imgRect.right > designAreaRect.right ||
        imgRect.top < designAreaRect.top ||
        imgRect.bottom > designAreaRect.bottom) {
        designError.style.display = 'block';
        return true;
    }
    
    designError.style.display = 'none';
    return false;
}

// Function to update the price
function updatePrice() {
    let price = basePrice;
    
    // Add additional cost for quantity
    price *= currentQuantity;
    
    // Add additional cost for larger sizes
    if (currentSize === 'L') price += 20;
    if (currentSize === 'XL') price += 30;
    if (currentSize === 'XXL') price += 50;
    
    // Update price displays
    priceDisplay.textContent = '₱' + price.toFixed(2);
    summaryPrice.textContent = '₱' + price.toFixed(2);
    
    return price;
}

// Function to update the summary view
function updateSummary() {
    // Update summary design preview
    if (designImage) {
        const summaryImg = summaryDesignArea.querySelector('img') || new Image();
        summaryImg.src = designImage.src;
        summaryImg.style.maxWidth = '100%';
        summaryImg.style.maxHeight = '100%';
        
        // Apply scale and position
        summaryImg.style.transform = `translate(${designXPosition}px, ${designYPosition}px) scale(${designScale/100})`;
        
        if (!summaryDesignArea.querySelector('img')) {
            summaryDesignArea.innerHTML = '';
            summaryDesignArea.appendChild(summaryImg);
        }
    }
    
    // Update summary text fields
    document.getElementById('summary-color').textContent = document.querySelector('.color-option.active').getAttribute('data-color').toUpperCase() === '#000000' ? 'Black' : 
                                                           document.querySelector('.color-option.active').getAttribute('data-color').toUpperCase() === '#FFFFFF' ? 'White' :
                                                           document.querySelector('.color-option.active').getAttribute('data-color').toUpperCase();
    document.getElementById('summary-size').textContent = currentSize;
    document.getElementById('summary-quantity').textContent = currentQuantity;
    updatePrice();
    
    // Update hidden form values
    document.getElementById('design-color').value = document.querySelector('.color-option.active').getAttribute('data-color').replace('#', '');
    document.getElementById('design-size').value = currentSize;
    document.getElementById('design-quantity').value = currentQuantity;
}

// Function to process uploaded image
function processImage(file) {
    if (!file) return;
    
    const reader = new FileReader();
    reader.onload = function(e) {
        const img = new Image();
        img.onload = function() {
            // Resize canvas to image dimensions
            processingCanvas.width = img.width;
            processingCanvas.height = img.height;
            
            // Draw image on canvas
            ctx.clearRect(0, 0, processingCanvas.width, processingCanvas.height);
            ctx.drawImage(img, 0, 0);
            
            // Create a new image from the canvas
            processedImage = new Image();
            processedImage.onload = function() {
                // Display the processed image
                const displayImg = designImage ? designImage : new Image();
                displayImg.src = processedImage.src;
                displayImg.style.maxWidth = '100%';
                displayImg.style.maxHeight = '100%';
                
                // Apply current transform values if they exist
                displayImg.style.transform = `translate(${designXPosition}px, ${designYPosition}px) scale(${designScale/100})`;
                
                if (!designImage) {
                    designArea.innerHTML = '';
                    designArea.appendChild(displayImg);
                    
                    // Add safety and bleed areas back
                    const safetyArea = document.createElement('div');
                    safetyArea.className = 'design-safety';
                    designArea.appendChild(safetyArea);
                    
                    const bleedArea = document.createElement('div');
                    bleedArea.className = 'design-bleed';
                    designArea.appendChild(bleedArea);
                    
                    const designLabels = document.createElement('div');
                    designLabels.className = 'design-labels';
                    designLabels.innerHTML = '<span class="design-label">Safety Area</span><span class="design-label">Bleed</span>';
                    designArea.appendChild(designLabels);
                }
                
                designImage = displayImg;
                designControls.style.display = 'block';
                
                // Check if design is within bounds
                isDesignOutOfBounds();
                
                // Save image data for form submission
                saveImageForSubmission();
            };
            processedImage.src = processingCanvas.toDataURL('image/png');
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

// Function to save processed image for form submission
function saveImageForSubmission() {
    const mainPreview = document.getElementById('main-preview');
    if (!mainPreview) return;

    html2canvas(mainPreview, {
        backgroundColor: null, // keep transparent if needed
        useCORS: true // allow cross-origin images if needed
    }).then(canvas => {
        document.getElementById('referenceImage').value = canvas.toDataURL('image/png');
    });
}

// Event Listeners
designUpload.addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        fileNameDisplay.textContent = this.files[0].name;
        processImage(this.files[0]);
    }
});

previewButton.addEventListener('click', function() {
    if (designUpload.files && designUpload.files[0]) {
        processImage(designUpload.files[0]);
    } else {
        alert('Please select a file first.');
    }
});

// Size slider control
sizeControl.addEventListener('input', function() {
    designScale = parseInt(this.value);
    sizeInput.value = designScale;
    
    if (designImage) {
        designImage.style.transform = `translate(${designXPosition}px, ${designYPosition}px) scale(${designScale/100})`;
        isDesignOutOfBounds();
        saveImageForSubmission();
    }
});

sizeInput.addEventListener('input', function() {
    let value = parseInt(this.value);
    if (value < 20) value = 20;
    if (value > 200) value = 200;
    
    designScale = value;
    sizeControl.value = value;
    this.value = value;
    
    if (designImage) {
        designImage.style.transform = `translate(${designXPosition}px, ${designYPosition}px) scale(${designScale/100})`;
        isDesignOutOfBounds();
        saveImageForSubmission();
    }
});

// Position Y slider control
positionYControl.addEventListener('input', function() {
    designYPosition = parseInt(this.value);
    positionYInput.value = designYPosition;
    
    if (designImage) {
        designImage.style.transform = `translate(${designXPosition}px, ${designYPosition}px) scale(${designScale/100})`;
        isDesignOutOfBounds();
        saveImageForSubmission();
    }
});

positionYInput.addEventListener('input', function() {
    let value = parseInt(this.value);
    if (value < -50) value = -50;
    if (value > 50) value = 50;
    
    designYPosition = value;
    positionYControl.value = value;
    this.value = value;
    
    if (designImage) {
        designImage.style.transform = `translate(${designXPosition}px, ${designYPosition}px) scale(${designScale/100})`;
        isDesignOutOfBounds();
        saveImageForSubmission();
    }
});

// Position X slider control
positionXControl.addEventListener('input', function() {
    designXPosition = parseInt(this.value);
    positionXInput.value = designXPosition;
    
    if (designImage) {
        designImage.style.transform = `translate(${designXPosition}px, ${designYPosition}px) scale(${designScale/100})`;
        isDesignOutOfBounds();
        saveImageForSubmission();
    }
});

positionXInput.addEventListener('input', function() {
    let value = parseInt(this.value);
    if (value < -50) value = -50;
    if (value > 50) value = 50;
    
    designXPosition = value;
    positionXControl.value = value;
    this.value = value;
    
    if (designImage) {
        designImage.style.transform = `translate(${designXPosition}px, ${designYPosition}px) scale(${designScale/100})`;
        isDesignOutOfBounds();
        saveImageForSubmission();
    }
});

// Quantity controls
quantityControl.addEventListener('input', function() {
    currentQuantity = parseInt(this.value);
    quantityInput.value = currentQuantity;
    updatePrice();
});

quantityInput.addEventListener('input', function() {
    let value = parseInt(this.value);
    if (isNaN(value) || value < 1) value = 1;
    if (value > 50) value = 50;
    
    currentQuantity = value;
    quantityControl.value = value;
    this.value = value;
    updatePrice();
});

// Color options
const colorOptions = document.querySelectorAll('.color-option');
colorOptions.forEach(option => {
    option.addEventListener('click', function() {
        // Remove active class from all options
        colorOptions.forEach(opt => opt.classList.remove('active'));
        
        // Add active class to clicked option
        this.classList.add('active');
        
        // Update t-shirt color
        const color = this.getAttribute('data-color');
        currentColor = color;
        
        // Update t-shirt preview color
        document.querySelector('.tshirt-image').style.backgroundColor = color;
        summaryTshirtBody.setAttribute('fill', color);
    });
});

// Size options
const sizeOptions = document.querySelectorAll('.size-option');
sizeOptions.forEach(option => {
    option.addEventListener('click', function() {
        // Remove active class from all options
        sizeOptions.forEach(opt => opt.classList.remove('active'));
        
        // Add active class to clicked option
        this.classList.add('active');
        
        // Update selected size
        currentSize = this.getAttribute('data-size');
        updatePrice();
    });
});

// Submit form handler
// document.getElementById('inquiryForm').addEventListener('submit', function(e) {
//     e.preventDefault();
    
//     // Check if design has been uploaded
//     if (!designImage) {
//         alert('Please upload a design image before submitting.');
//         switchTab('design-tab');
//         return false;
//     }
    
//     // Check if design is within bounds
//     if (isDesignOutOfBounds()) {
//         alert('Your design is exceeding the allowed area. Please adjust the size or position.');
//         switchTab('design-tab');
//         return false;
//     }
    
//     // Convert the design preview to image for submission
//     html2canvas(designArea).then(canvas => {
//         // Update hidden field with the design image data
//         document.getElementById('referenceImage').value = canvas.toDataURL('image/png');
        
//         // Submit the form
//         this.submit();
//     });
// });

// Startup code
function initializePage() {
    // Set the initial price
    updatePrice();
    
    <?php if(empty($_SESSION['user_id'])): ?>
    // Show login modal for non-logged in users
    document.getElementById('loginModal').style.display = 'flex';
    <?php endif; ?>
}

// Initialize the page when loaded
initializePage();

// Drag and drop handling for the design area
let isDragging = false;
let startX, startY, startPosX, startPosY;

function setupDragAndDrop() {
    if (!designImage) return;
    
    designImage.addEventListener('mousedown', startDrag);
    document.addEventListener('mousemove', drag);
    document.addEventListener('mouseup', stopDrag);
    
    // Touch events for mobile
    designImage.addEventListener('touchstart', startDrag);
    document.addEventListener('touchmove', drag);
    document.addEventListener('touchend', stopDrag);
}

function startDrag(e) {
    e.preventDefault();
    isDragging = true;
    
    // Get starting position
    if (e.type === 'touchstart') {
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
    } else {
        startX = e.clientX;
        startY = e.clientY;
    }
    
    startPosX = designXPosition;
    startPosY = designYPosition;
}

function drag(e) {
    if (!isDragging) return;
    
    let currentX, currentY;
    
    if (e.type === 'touchmove') {
        currentX = e.touches[0].clientX;
        currentY = e.touches[0].clientY;
    } else {
        currentX = e.clientX;
        currentY = e.clientY;
    }
    
    // Calculate new position
    const deltaX = currentX - startX;
    const deltaY = currentY - startY;
    
    designXPosition = startPosX + deltaX / 2; // Divide by 2 for more controlled movement
    designYPosition = startPosY + deltaY / 2;
    
    // Limit position range
    if (designXPosition < -50) designXPosition = -50;
    if (designXPosition > 50) designXPosition = 50;
    if (designYPosition < -50) designYPosition = -50;
    if (designYPosition > 50) designYPosition = 50;
    
    // Update sliders and inputs
    positionXControl.value = designXPosition;
    positionYControl.value = designYPosition;
    positionXInput.value = designXPosition;
    positionYInput.value = designYPosition;
    
    // Update design position
    designImage.style.transform = `translate(${designXPosition}px, ${designYPosition}px) scale(${designScale/100})`;
    
    // Check if design is within bounds
    isDesignOutOfBounds();
    
    // Save image for submission
    saveImageForSubmission();
}

function stopDrag() {
    isDragging = false;
}

// Add event listeners when design is loaded
const checkDesignInterval = setInterval(() => {
    if (designImage) {
        setupDragAndDrop();
        clearInterval(checkDesignInterval);
    }
}, 100);

// Form validation
function validateForm() {
    const form = document.getElementById('inquiryForm');
    const requiredFields = form.querySelectorAll('[required]');
    let valid = true;
    
    requiredFields.forEach(field => {
        if (!field.value) {
            field.classList.add('is-invalid');
            valid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });
    
    return valid;
}

// Reset form if needed
function resetForm() {
    document.getElementById('inquiryForm').reset();
    
    // Reset design settings
    designScale = 100;
    designXPosition = 0;
    designYPosition = 0;
    
    // Update UI controls
    sizeControl.value = designScale;
    sizeInput.value = designScale;
    positionXControl.value = designXPosition;
    positionXInput.value = designXPosition;
    positionYControl.value = designYPosition;
    positionYInput.value = designYPosition;
    
    // Reset design preview
    if (designImage) {
        designImage.style.transform = `translate(0px, 0px) scale(1)`;
    }
}

// Success message display after form submission (if needed)
function showSuccessMessage() {
    // Create a success message element
    const successMsg = document.createElement('div');
    successMsg.className = 'alert alert-success';
    successMsg.textContent = 'Your design inquiry has been submitted successfully! We will contact you soon.';
    
    // Insert at the top of the form
    const form = document.getElementById('inquiryForm');
    form.parentNode.insertBefore(successMsg, form);
    
    // Scroll to success message
    successMsg.scrollIntoView({ behavior: 'smooth' });
    
    // Remove success message after 5 seconds
    setTimeout(() => {
        successMsg.remove();
    }, 5000);
}

// Handle form submission response
document.getElementById('inquiryForm').addEventListener('submit', function(e) {
    e.preventDefault();

    if (!validateForm()) {
        alert('Please fill in all required fields.');
        return;
    }

    // Show loading indicator
    const submitBtn = document.getElementById('submit-inquiry');
    const originalBtnText = submitBtn.textContent;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...';
    submitBtn.disabled = true;

    // Gather form data as JSON
    const form = this;
    const data = {
        name: form.name.value,
        email: form.email.value,
        phone: form.phone.value,
        description: form.description.value,
        timeline: form.timeline.value,
        additional_info: form.additional_info.value,
        color: form.color.value,
        size: form.size.value,
        quantity: form.quantity.value,
        referenceImage: form.referenceImage.value
    };

    fetch(form.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.innerHTML = originalBtnText;
        submitBtn.disabled = false;

        if (data.success) {
            showSuccessMessage();
            setTimeout(function() {
                window.location.reload();
            }, 2000);
        } else {
            alert(data.error || data.message || 'There was an error submitting your inquiry. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        submitBtn.innerHTML = originalBtnText;
        submitBtn.disabled = false;
        alert('There was an error submitting your inquiry. Please try again later.');
    });
});

// Add window resize handler to ensure design stays within bounds
window.addEventListener('resize', function() {
    if (designImage) {
        // Recalculate if design is within bounds
        setTimeout(isDesignOutOfBounds, 300);
    }
});

}); // End of DOMContentLoaded
</script>