const container = document.querySelector('.container');
const generated_links = document.querySelector('.table-body');
const individual_stats = document.createElement("div");
const main_div = document.querySelector('.black-tint');
container_created = false;

fetch('./userlinks.php')
    .then(response => {
        return response.json();
    })
    .then(data => {
        let html = "";
        for (let i = 0; i < data.input.length; i++) {
            html += `
            <tr>
                <td class='inpcell'>${data.input[i]}</td>
                <td class='outcell'>${data.output[i]}</td>
            </tr>`
        }
        generated_links.innerHTML =
            `<table class='links-table'>
                <thead>
                    <th>Link Input</th>
                    <th>Link Output</th>
                </thead
                <tbody>
                    ${html}
                </tbody>
            </table>`;
    })
    .then(item => {
        const table_inpCell = document.querySelectorAll('.inpcell');
        let cell_added = false;
        table_inpCell.forEach((cell) => {
            // Dynamically creates the new div for the individual link insights
            cell.style.cursor = "pointer";
            cell.addEventListener('click', (e) => {
                if (!cell_added) {
                    const individual_link_insight = document.createElement('div');
                    individual_link_insight.classList.add('personal-links');
                    individual_link_insight.classList.add('insights-panel');
                    main_div.append(individual_link_insight);
                    cell_added = true;
                } else {
                    const individual_link_insight = document.querySelector('.insights-panel');
                    individual_link_insight.innerHTML = ``;
                }
                // Sends the link as a query string to the server to retrieve results and returns a
                const url = e.target.textContent.trim();
                console.log(url);
                const url_param = new URLSearchParams({ input: url }).toString();
                console.log(url_param);
                fetch(`./linkinsights.php?${url_param}`)
                    .then(response => response.json())
                    .then(data => {
                        const individual_link_insight = document.querySelector('.insights-panel');
                        const individual_link_insight_graph =
                            `<div class='insight-panel-content p1'><canvas id='link_insights' style='width: 100%; max-width:700px'></canvas><h1>Insights for: ${cell.textContent}</h1></div>
                            <div class='insight-panel-content p2'>Placeholder 2</div>
                            <div class='insight-panel-content p3'>Placeholder 3</div>`;
                        individual_link_insight.innerHTML = `${individual_link_insight_graph}`;
                        const chart = new Chart('link_insights', {
                            type: 'bar',
                            data: {
                                labels: [url],
                                datasets: [{
                                    label: 'Times Clicked',
                                    backgroundColor: 'skyblue',
                                    data: [data.times_clicked],
                                    barThickness: 100
                                }]
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                },
                                legend: {
                                    display: false
                                }
                            }
                        });
                    })
            })
        })
    })


