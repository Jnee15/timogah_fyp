const wheel = document.getElementById("wheel");
const spinButton = document.getElementById("spin-button");
const finalValue = document.getElementById("final-value");
const result = document.getElementById("result");

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
            result.innerHTML = `<p>You earned ${pointsEarned} points. Total points: ${totalPoints}</p>`; // Clear previous result and add new one
            updatePoints(totalPoints); // Send the total points to the server
            spinButton.disabled = false;
            break;
        }
    }
};

const updatePoints = (points) => {
    fetch('update_points.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ points: points })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Points updated successfully.');
            } else {
                console.error('Failed to update points.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
};

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
