import { Link, useNavigate } from "react-router-dom"
const Header = ({ deleteAction }) => {
    const navigate = useNavigate();

    const handleClick = () => {
        deleteAction();
        navigate('/')
    }
    
    return (
        <header className="flex justify-between border-b-4 border-black py-6 px-4">
            <h1 className="text-5xl">Product List</h1>
            <div className="flex items-center gap-4">
                <Link to="/add-product" className="px-4 py-3 bg-black text-white">ADD</Link>
                <button type="button" className="px-4 py-3 bg-black text-white" onClick={handleClick}>MASS DELETE</button>
            </div>
        </header>
    )
}

export default Header
