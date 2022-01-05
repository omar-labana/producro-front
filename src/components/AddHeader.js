import { Link } from "react-router-dom"

const Header = () => {
    return (
        <header className="flex justify-between border-b-4 border-black py-6 px-4">
            <h1 className="text-5xl">Product List</h1>
            <div className="flex items-center gap-4">
                <button type="button" className="px-4 py-3 bg-black text-white" form="product_form" type="submit">Save</button>
                <Link to="/" className="px-4 py-3 bg-black text-white">Cancel</Link>
            </div>
        </header>
    )
}

export default Header
