const Product = ({ data, queueSetter }) => {
    const { id } = data
    const handleChange = () => {
        queueSetter((prevState) => {
            const result = prevState.filter(item => item.id === id);
            if (result !== [] && result.length > 0) {
                console.log(result)
                return result;
            } else {
                console.log([...prevState, data])
                return [...prevState, data];
            }
        })
    };

    return (
        <li className="border-2 border-slate-900 rounded-lg p-4 ">
            <input type="checkbox" className="delete-checkbox" onChange={handleChange} />
            <ul className="text-center">
                <li>
                    {data.sku}
                </li>
                <li>
                    {data.name}
                </li>
                <li>
                    {data.price} $
                </li>
                <li>
                    {data.type === "DVD" && `Size: ${data.size}`}
                    {data.type === "Book" && `Weight: ${data.weight}`}
                    {data.type === "Furniture" && `Dimentions: ${data.height}*${data.width}*${data.length}`}
                </li>
            </ul>
        </li>
    )
}

export default Product
