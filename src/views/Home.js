import List from '../components/List'
import HomeHeader from '../components/HomeHeader';

import { useEffect, useState } from 'react'
const Home = () => {
    const [products, setProducts] = useState([])
    const [deleteQueue, setDeleteQueue] = useState([])
    useEffect(() => {
        fetch('https://producto-back.000webhostapp.com/api/read_all.php')
            .then(results => results.json())
            .then(data => setProducts(data));
    }, [])

    const deleteSelected = () => {
        const url = "https://producto-back.000webhostapp.com/api/delete_many.php";
        fetch(url, {
            method: 'DELETE',
            body: JSON.stringify({ targets: deleteQueue }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(() => {
                console.log("done")
            })
            .catch(err => console.log(err));
        setDeleteQueue([]);
    }

    return (
        <>
            <HomeHeader deleteAction={deleteSelected} />
            <main>
                <List products={products} queueSetter={setDeleteQueue} />
            </main>
        </>
    )
}

export default Home
