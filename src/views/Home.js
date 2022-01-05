import List from '../components/List'
import HomeHeader from '../components/HomeHeader';

import { useEffect, useState } from 'react'
const Home = () => {
    const [products, setProducts] = useState([])
    const [deleteQueue, setDeleteQueue] = useState([])

    useEffect(() => {
        fetch('https://producto-task.000webhostapp.com/api/read_all.php')
            .then(results => results.json())
            .then(data => setProducts(data.data));
    }, [])

    const deleteSelected = () => {
        const checked = document.querySelectorAll(".delete-checkbox:checked");
        const ids = [];
        for (let i = 0; i < checked.length; i++) {
            ids.push(checked[i].parentNode.childNodes[1].childNodes[0].innerHTML);
        }
        const tar = products.filter(item => ids.includes(item.sku))
        const url = "/api/delete_many.php";
        fetch(url, {
            method: 'POST',
            body: JSON.stringify({ targets: tar }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(() => {
                console.log("done")
                fetch('https://producto-task.000webhostapp.com/api/read_all.php')
                    .then(results => results.json())
                    .then(data => setProducts(data.data));
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
