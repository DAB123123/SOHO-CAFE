<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/styles.css?v=2" />
    <title>Manage Size Pricing - Admin Dashboard</title>
    <style>
        html {
            font-size: 0.8750em;
        }
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .pricing-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            min-height: 280px;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .size-preview {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }
        .size-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f5a637, #ff6b35);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            flex-shrink: 0;
        }
        .price-example {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-top: auto;
            min-height: 60px;
        }
        .form-group {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .multiplier-input {
            height: 40px;
        }
        .save-btn {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            color: white;
            padding: 15px 30px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
            font-weight: bold;
            margin: 20px auto;
            display: block;
        }
        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }
    </style>
</head>
<body id="body">
    <div class="container-fluid">
        <?php require_once 'nav_admin.php' ?>
        
        <main>
            <div class="main__container">
                <div class="main__title">
                    <img src="assets/hello.svg" alt="" />
                    <div class="main__greeting">
                        <h1>Size Pricing Management</h1>
                        <p>Manage drink size pricing multipliers</p>
                    </div>
                </div>
                <br>

                <div id="message-area"></div>

                <section class="content">
                    <div class="pricing-container">
                        <?php
                        require_once "config.php";
                        
                        // Handle form submission
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            $updated = false;
                            foreach ($_POST as $key => $value) {
                                if (strpos($key, 'multiplier_') === 0) {
                                    $sizeId = str_replace('multiplier_', '', $key);
                                    $multiplier = floatval($value);
                                    
                                    if ($multiplier > 0 && $multiplier <= 5) { // Reasonable limits
                                        $stmt = $conn->prepare("UPDATE size_pricing SET multiplier = ? WHERE id = ?");
                                        $stmt->bind_param("di", $multiplier, $sizeId);
                                        if ($stmt->execute()) {
                                            $updated = true;
                                        }
                                    }
                                }
                            }
                            
                            if ($updated) {
                                echo '<div class="alert alert-success">Size pricing updated successfully!</div>';
                            }
                        }
                        
                        // Fetch current size pricing
                        $sql = "SELECT * FROM size_pricing WHERE is_active = 1 ORDER BY 
                            CASE size_name 
                                WHEN 'short' THEN 1 
                                WHEN 'tall' THEN 2 
                                WHEN 'grande' THEN 3 
                                WHEN 'venti' THEN 4 
                                ELSE 5 
                            END";
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            echo '<form method="POST">';
                            echo '<div class="pricing-grid">';
                            
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <div class="pricing-card" data-size="<?php echo $row['size_name']; ?>">
                                    <div class="size-preview">
                                        <div class="size-icon">
                                            <?php echo strtoupper(substr($row['size_name'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <h4><?php echo ucfirst($row['size_name']); ?></h4>
                                            <p class="text-muted"><?php echo $row['size_description']; ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Price Multiplier</label>
                                        <div class="input-group">
                                            <input type="number" 
                                                   name="multiplier_<?php echo $row['id']; ?>" 
                                                   value="<?php echo $row['multiplier']; ?>" 
                                                   step="0.01" 
                                                   min="0.1" 
                                                   max="5" 
                                                   class="form-control multiplier-input" 
                                                   data-size="<?php echo $row['size_name']; ?>">
                                            <span class="input-group-addon">x</span>
                                        </div>
                                        <small class="help-block">Base price will be multiplied by this value</small>
                                    </div>
                                    
                                    <div class="price-example">
                                        <strong>Example:</strong>
                                        <div>Base Price: ₱100</div>
                                        <div class="text-primary">
                                            <span class="size-name"><?php echo ucfirst($row['size_name']); ?></span> Price: 
                                            <span class="calculated-price">₱<?php echo number_format(100 * $row['multiplier'], 0); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            
                            echo '</div>'; // Close pricing-grid
                            echo '<button type="submit" class="save-btn">
                                    <i class="fa fa-save"></i> Save All Changes
                                  </button>';
                            echo '</form>';
                        } else {
                            echo '<div class="alert alert-warning">No size pricing data found. Please run the database update script.</div>';
                        }
                        
                        $conn->close();
                        ?>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        // Real-time price calculation preview with smoother updates
        $(document).ready(function() {
            $('.multiplier-input').on('input', function() {
                const $input = $(this);
                const multiplier = parseFloat($input.val()) || 1;
                const basePrice = 100;
                const newPrice = basePrice * multiplier;
                const $card = $input.closest('.pricing-card');
                const $priceDisplay = $card.find('.calculated-price');
                
                // Smooth update with animation
                $priceDisplay.fadeOut(100, function() {
                    $(this).text('₱' + Math.round(newPrice)).fadeIn(100);
                });
                
                // Add visual feedback for valid ranges
                if (multiplier >= 0.1 && multiplier <= 5) {
                    $input.removeClass('error').addClass('valid');
                } else {
                    $input.removeClass('valid').addClass('error');
                }
            });
            
            // Add CSS for validation feedback
            $('<style>')
                .prop('type', 'text/css')
                .html(`
                    .multiplier-input.valid {
                        border-color: #28a745;
                        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
                    }
                    .multiplier-input.error {
                        border-color: #dc3545;
                        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
                    }
                    .pricing-card {
                        transition: transform 0.2s ease;
                    }
                    .pricing-card:hover {
                        transform: translateY(-2px);
                    }
                `)
                .appendTo('head');
        });
    </script>

    <!-- Navigation Active Link Script -->
    <script src="assets/js/script.js"></script>
</body>
</html>