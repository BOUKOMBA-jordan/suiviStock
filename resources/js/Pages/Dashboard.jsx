import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import Histogramme from './Graphes/Histogramme .jsx';
import BarChart from './Graphes/BarChart.jsx';
import BarChartReference from './Graphes/BarChartReference.jsx';
import LineChart from './Graphes/LineChart.jsx';
import Camembert from './Graphes/Camembert.jsx';
import ChartLabel from './Graphes/ColumnChart.jsx';
import DoughnutChart from './Graphes/DoughnutChart.jsx';




export default function Dashboard({ auth, utilisateur_has_produits, total_ventes_par_utilisateur, ventes_totales_par_jour, results, ventes_par_mois_par_utilisateur }) {

    const year = 2024;
    const month = 5;



    return (
        <AuthenticatedLayout
            user={auth.user}
            year={year} month={month}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-6">
                <div className='mx-auto sm:px-6 lg:px-8'>
                    <div className=" overflow-hidden  shadow-sm rounded-lg sm:rounded-lg">
                        <div className='row'>
                            <LineChart data={ventes_totales_par_jour} />
                        </div>
                        <div className='row'>
                            <div className='col-md-3 col-lg-3 mt-5'>
                                <Histogramme data={utilisateur_has_produits} />,
                            </div>
                            <div className='col-md-3 col-lg-3 mt-5'>
                                <Histogramme data={utilisateur_has_produits} />,
                            </div>

                            <div className='col-md-6 col-lg-6 mt-5'>
                                <BarChartReference data={results} />
                            </div>
                        </div>

                        <div className='row'>
                            <div className='col-md-6 mt-5'>
                                <BarChart data={total_ventes_par_utilisateur} />
                            </div>
                            <div className='col-md-6 mt-5'>
                                <ChartLabel data={ventes_par_mois_par_utilisateur} />
                            </div>
                        </div>

                        <div className='row'>

                            <div className='col-md-3 col-lg-3 mt-5'>
                                <Camembert />
                            </div>
                            <div className='col-md-3 col-lg-3 mt-5'>
                            <DoughnutChart />
                            </div>
                            <div className='col-md-3 col-lg-3 mt-5'>
                            <DoughnutChart />
                            </div>
                            <div className='col-md-3 col-lg-3 mt-5'>
                            <DoughnutChart />
                            </div>

                        </div>

                    </div>
                </div>
            </div>




            <div className="py-6">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">Je me connecte</div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
