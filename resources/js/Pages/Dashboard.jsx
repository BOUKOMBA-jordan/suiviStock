import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import Histogramme from './Graphes/Histogramme .jsx';
import BarChart from './Graphes/BarChart.jsx';
import LineChart from './Graphes/LineChart.jsx';
import Camembert from './Graphes/Camembert.jsx'
import ChartLabel from './Graphes/ColumnChart.jsx'

export default function Dashboard({ auth, utilisateur_has_produits }) {

    const dataPoints = [
        { label: "Apple", y: 10 },
        { label: "Orange", y: 15 },
        { label: "Banana", y: 25 },
        { label: "Mango", y: 30 },
        { label: "Grape", y: 28 }
    ];


    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-6">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                        <pre>{JSON.stringify(utilisateur_has_produits, undefined, 1)}</pre>
                        </div>
                    </div>
                </div>
            </div>
            
            <div className="py-6">
                <div className='max-w-7xl mx-auto sm:px-6 lg:px-8'>
                    <div className=" overflow-hidden shadow-sm sm:rounded-lg">
                        <div>
                              <Histogramme data={utilisateur_has_produits} />,
                        </div>
                        <div>
                            <BarChart />
                        </div>
                        <div>
                            <ChartLabel />
                        </div>
                        <div>
                            <LineChart />
                        </div>
                        <div>
                            <Camembert />
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
