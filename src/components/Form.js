import { useState } from 'react'
import { useNavigate } from "react-router-dom"


const Form = () => {
    const [type, setType] = useState('DVD')
    const [product, setProduct] = useState({
        sku: '',
        name: '',
        price: '',
        size: '',
        type: 'DVD',
    })

    const navigate = useNavigate();

    const handleSubmit = (e) => {

        e.preventDefault();
        console.log(JSON.stringify(product))
        const url = "https://producto-back.000webhostapp.com/api/add_product.php";
        fetch(url, {
            method: 'PUT',
            body: JSON.stringify(product),
            headers: {
                'Content-Type': 'application/json',
                'Allow-Control-Allow-Origin': '*'
            }
        })
            .then(() => {
                navigate('/')
            })
            .catch(err => console.log(err));
    }

    const handleChange = (e) => {
        setType(e.target.value);
        console.log(e.target.value);
        switch (e.target.value) {
            case 'DVD':
                setProduct((prevState) => {
                    return {
                        sku: prevState.sku,
                        name: prevState.name,
                        price: prevState.price,
                        size: '',
                        type: 'DVD',
                    }
                })
                break;
            case 'Book':
                setProduct((prevState) => {
                    return {
                        sku: prevState.sku,
                        name: prevState.name,
                        price: prevState.price,
                        weight: '',
                        type: 'Book',
                    }
                })
                break;
            case 'Furniture':
                setProduct((prevState) => {
                    return {
                        sku: prevState.sku,
                        name: prevState.name,
                        price: prevState.price,
                        height: '',
                        width: '',
                        length: '',
                        type: 'Furniture',
                    }
                })
                break;
            default:
                break;
        }
    }

    const handleInput = (e) => {
        setProduct({
            ...product,
            [e.target.name]: e.target.value
        })
    }

    return (
        <form id="product_form" className="flex flex-col p-6" onSubmit={handleSubmit}>
            <input className="border-4 border-slate-800 my-1 rounded-lg w-64 p-3" type="text" name="sku" placeholder="SKU" id="sku" required value={product.sku} onChange={handleInput} />
            <input className="border-4 border-slate-800 my-1 rounded-lg w-64 p-3" type="text" name="name" placeholder="Name" id="name" required onChange={handleInput} />
            <input className="border-4 border-slate-800 my-1 rounded-lg w-64 p-3" type="text" name="price" placeholder="Price $" id="price" required onChange={handleInput} />
            <label htmlFor="productType" className="text-xl mt-4">Type Switcher</label>
            <select className="border-4 border-slate-800 my-1 rounded-lg w-64 p-3" name="productType" id="productType" onChange={handleChange} value={type} required>
                <option value="DVD" id="DVD">DVD</option>
                <option value="Book" id="Book">Book</option>
                <option value="Furniture" id="Furniture">Furniture</option>
            </select>
            {type === 'DVD' && <>
                <label htmlFor="dvdSize" className="text-xl mt-4">Size (MB)</label>
                <input className="border-4 border-slate-800 my-1 rounded-lg w-64 p-3" type="number" name="size" placeholder="Size" id="size" required onChange={handleInput} />
            </>
            }
            {type === 'Book' && <>
                <label htmlFor="bookWeight" className="text-xl mt-4">Weight (KG)</label>
                <input className="border-4 border-slate-800 my-1 rounded-lg w-64 p-3" type="number" name="weight" placeholder="Weight" id="weight" required onChange={handleInput} />
            </>
            }
            {type === 'Furniture' && <>
                <label htmlFor="furnitureHeight" className="text-xl mt-4">Height (CM)</label>
                <input className="border-4 border-slate-800 my-1 rounded-lg w-64 p-3" type="number" name="height" placeholder="Height" id="height" required onChange={handleInput} />
                <label htmlFor="furnitureWidth" className="text-xl mt-4">Width (CM)</label>
                <input className="border-4 border-slate-800 my-1 rounded-lg w-64 p-3" type="number" name="width" placeholder="Width" id="width" required onChange={handleInput} />
                <label htmlFor="furnitureDepth" className="text-xl mt-4">Depth (CM)</label>
                <input className="border-4 border-slate-800 my-1 rounded-lg w-64 p-3" type="number" name="length" placeholder="Length" id="length" required onChange={handleInput} />
            </>
            }
        </form>
    )
}

export default Form
