<script>
function startTime() {
    const today = new Date();
    let h = today.getHours();
    const ampm = h >= 12 ? 'PM' : 'AM';
    h = h % 12 || 12; // Convert to 12-hour format
    let m = today.getMinutes();
    let s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('clock').innerHTML = 
        `${h}:${m}:${s} <small>${ampm}</small>`;
    setTimeout(startTime, 500);
}
function checkTime(i) {
    return (i < 10) ? "0" + i : i;
}
</script>

<body onload="startTime()">
    <div class="info-dashboard me-5">
        <!-- Date/Time/Day Panel -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-clock"></i> Current Time
            </div>
            <div class="info-card-body">
                <div class="info-item">
                    <i class="fas fa-calendar-day"></i>
                    <span class="info-label">Date:</span>
                    <span class="info-value"><?php echo date("F j, Y"); ?></span>
                </div>
                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <span class="info-label">Time:</span>
                    <span class="info-value" id="clock"></span>
                </div>
                <div class="info-item">
                    <i class="fas fa-calendar-week"></i>
                    <span class="info-label">Day:</span>
                    <span class="info-value"><?php echo date("l"); ?></span>
                </div>
            </div>
        </div>

        <!-- Ministry Info Panel -->
        <div class="info-card ">
            <div class="info-card-header">
                <i class="fas fa-landmark"></i> Education Ministry
            </div>
            <div class="info-card-body">
                <div class="contact-person">
                    <i class="fas fa-user-tie"></i>
                    <span>Dr. Harini Amarasooriya</span>
                </div>
            </div>
        </div>

        <!-- PDE Central Panel -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-university"></i> PDE Central
            </div>
            <div class="info-card-body">
                <div class="contact-person">
                    <i class="fas fa-user-tie"></i>
                    <span>Mr. Sthiyendra</span>
                </div>
            </div>
        </div>
    </div>
</body>

<style>
:root {
    --primary-color: #3498db;
    --secondary-color: #2c3e50;
    --light-color: #f8f9fa;
    --dark-color: #343a40;
}

.info-dashboard {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    padding: 0;
    max-width: 1200px;
    margin: 0 auto;
}

.info-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease;
}

.info-card:hover {
    transform: translateY(-5px);
}

.info-card-header {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 15px 20px;
    font-weight: 600;
    font-size: 1.1rem;
}

.info-card-header i {
    margin-right: 10px;
}

.info-card-body {
    padding: 20px;
}

.info-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    font-size: 1rem;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-item i {
    color: var(--primary-color);
    width: 25px;
    text-align: center;
    margin-right: 10px;
}

.info-label {
    font-weight: 600;
    color: var(--secondary-color);
    margin-right: 8px;
    min-width: 50px;
}

.info-value {
    color: var(--dark-color);
}

#clock {
    font-family: 'Courier New', monospace;
    font-weight: bold;
    color: var(--primary-color);
}

#clock small {
    font-size: 0.8em;
    color: #6c757d;
}

.contact-person {
    display: flex;
    align-items: center;
    padding: 10px;
    background-color: rgba(52, 152, 219, 0.1);
    border-radius: 5px;
}

.contact-person i {
    color: var(--secondary-color);
    margin-right: 10px;
}

.contact-person span {
    font-weight: 500;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .info-dashboard {
        grid-template-columns: 1fr;
    }
}
</style>