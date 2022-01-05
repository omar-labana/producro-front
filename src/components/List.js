import Product from './Product'

const List = ({ products, queueSetter }) => {
    return (
        <ul className="grid grid-cols-4 m-5 content-center gap-4">
            {products.map(product => <Product data={product} key={product.id} queueSetter={queueSetter} />)}
        </ul>
    )
}

export default List
