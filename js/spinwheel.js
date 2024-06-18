const wheel = document.getElementById("wheel");
const spinButton = document.getElementById("spin-button");
const finalValue = document.getElementById("final-value");
const result = document.getElementById("result");
const redeemButton = document.getElementById("redeem-button");
const voucherSelect = document.getElementById("voucher-select");
const redeemMessage = document.getElementById("redeem-message");

let totalPoints = parseInt(finalValue.querySelector("p").textContent.split(": ")[1]);

const rotationValues = [
    { minDegree: 0, maxDegree: 30, value: 2 },
    { minDegree: 31, maxDegree: 90, value: 1 },
    { minDegree: 91, maxDegree: 150, value: 6 },
    { minDegree: 151, maxDegree: 210, value: 5 },
    { minDegree: 211, maxDegree: 270, value: 0 },
    { minDegree: 271, maxDegree: 330, value: 3 },
    { minDegree: 331, maxDegree: 360, value: 2 },
];

const data = [16, 16, 16, 16, 16, 16];
var pieColors = [
    "#f1a3dd",
    "#a8e5ff",
    "#f1a3dd",
    "#a8e5ff",
    "#f1a3dd",
    "#a8e5ff",
];

let myChart = new Chart(wheel, {
    plugins: [ChartDataLabels],
    type: "pie",
    data: {
        labels: [1, 2, 3, 0, 5, 6],
        datasets: [
            {
                backgroundColor: pieColors,
                data: data,
            },
        ],
    },
    options: {
        responsive: true,
        animation: { duration: 0 },
        plugins: {
            tooltip: false,
            legend: {
                display: false,
            },
            datalabels: {
                color: "#ffffff",
                formatter: (_, context) => context.chart.data.labels[context.dataIndex],
                font: { size: 24 },
            },
        },
    },
});

const valueGenerator = (angleValue) => {
    for (let i of rotationValues) {
        if (angleValue >= i.minDegree && angleValue <= i.maxDegree) {
            const pointsEarned = i.value;
            totalPoints += pointsEarned;
            finalValue.innerHTML = `<p>Points: ${totalPoints}</p>`;
            result.innerHTML = `
                <p>You earned ${pointsEarned} points. Total points: ${totalPoints}.</p>
                <p>You have already spun the wheel today. Come back tomorrow!</p>
            `;
            updatePoints(pointsEarned); // Send the points earned to the server
            break;
        }
    }
};

const updatePoints = (pointsEarned) => {
    fetch('update_spin_time.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ points: pointsEarned })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Points and spin time updated successfully.');
            } else {
                console.error('Failed to update points and spin time:', data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
};

const redeemVoucher = () => {
    const selectedVoucher = voucherSelect.value;
    fetch('redeem_voucher.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `voucher=${selectedVoucher}`
    })
        .then(response => response.json())
        .then(data => {
            redeemMessage.innerHTML = data.message;
            if (data.success) {
                totalPoints -= parseInt(selectedVoucher);
                finalValue.innerHTML = `<p>Points: ${totalPoints}</p>`;
                updateVoucherList();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
};

const updateVoucherList = () => {
    fetch('get_vouchers.php')
        .then(response => response.json())
        .then(data => {
            const voucherList = document.getElementById('voucher-list');
            voucherList.innerHTML = '';
            if (data.vouchers.length > 0) {
                data.vouchers.forEach(voucher => {
                    const li = document.createElement('li');
                    li.textContent = `RM${voucher.discount} Discount`;
                    voucherList.appendChild(li);
                });
            } else {
                voucherList.innerHTML = '<li>No vouchers redeemed yet.</li>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
};

redeemButton.addEventListener("click", redeemVoucher);

let count = 0;
let resultValue = 101;

spinButton.addEventListener("click", () => {
    spinButton.disabled = true;
    result.innerHTML = `<p>Good Luck!</p>`; // Clear previous result message
    let randomDegree = Math.floor(Math.random() * (355 - 0 + 1) + 0);
    let rotationInterval = window.setInterval(() => {
        myChart.options.rotation = myChart.options.rotation + resultValue;
        myChart.update();
        if (myChart.options.rotation >= 360) {
            count += 1;
            resultValue -= 5;
            myChart.options.rotation = 0;
        } else if (count > 15 && myChart.options.rotation == randomDegree) {
            valueGenerator(randomDegree);
            clearInterval(rotationInterval);
            count = 0;
            resultValue = 101;
        }
    }, 10);
});
