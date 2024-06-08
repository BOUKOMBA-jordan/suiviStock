import React, { Component } from 'react';
import CanvasJSReact from '@canvasjs/react-charts';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

var CanvasJSChart = CanvasJSReact.CanvasJSChart;
 
class Histogramme  extends Component {
		render() {

			 // Utiliser les données passées en tant que prop
			 const { data } = this.props;

			  // Transformer les données en dataPoints pour le graphique
			  const dataPoints = data.map(item => ({
				label: item.date,
				y: parseInt(item.total_quantite, 10)
			}));


		const options = {
			title: {
				text: "Vente en carton"
			},
			animationEnabled: true,
			data: [
			{
				// Change type to "doughnut", "line", "splineArea", etc.
				type: "column",
				dataPoints: dataPoints,
				indexLabel: "{y}",
			}
			]
		}
		
		return (
		<div>
			
			<CanvasJSChart options = {options} 
				/* onRef={ref => this.chart = ref} */
			/>
			{/*You can get reference to the chart instance as shown above using onRef. This allows you to access all chart properties and methods*/}
		</div>
		);
	}
}

export default Histogramme ;