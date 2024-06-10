import React, { Component } from 'react';
import CanvasJSReact from '@canvasjs/react-charts';
var CanvasJSChart = CanvasJSReact.CanvasJSChart;

class LineChart extends Component {
    render() {
        // Utiliser les données passées en tant que prop
        const { data } = this.props;

        // Transformer les données en dataPoints pour le graphique
        const dataPoints = data.map(item => ({
            x: new Date(item.date),
            y: parseInt(item.total_vente)
        }));

        const options = {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light2", // "light1", "dark1", "dark2"
            title: {
                text: "Chiffre d'Affaire"
            },
            axisY: {
                includeZero: true,
                suffix: "FCFA"
            },
            axisX: {
                title: "Date",
                
            },
            data: [{
                type: "line",
                toolTipContent: "Date: {x}<br/>Total Vente: {y} FCFA",
				indexLabel: "{y} FCFA",
                dataPoints: dataPoints
            }]
        }

        return (
            <div>
                <CanvasJSChart options={options} />
            </div>
        );
    }
}

export default LineChart;
