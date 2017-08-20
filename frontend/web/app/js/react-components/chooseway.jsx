export default class Chooseway extends React.Component {

    constructor(props){
        super(props)

        this.state = {
            categories: []
        }

        this.handleChoose = this.handleChoose.bind(this)
        this.getJsonData = this.getJsonData.bind(this)
        this.loadCategories = this.loadCategories.bind(this)
    }

    componentDidMount(){
        this.loadCategories()
    }

    handleClickCategoryElement(object) {
        this.loadCategories()
    }

    handleTotalUpdate(dataList){
        this.currentPointer;
    }

    loadCategories(object){
        var _this = this,
            categories = this.state.categories

        $.ajax({
            url: this.props.url,
            dataType: 'json',
            data: {},
            success: function(data){
                categories.push(data)

                _this.updateCategoriesList(object).bind(_this)
                if (typeof object.serialNumber === 'number' ){
                    categories.splice(object.serialNumber+2)
                }

               _this.setState({categories: categories})
            }
        })

        return
    }

    updateCategoriesList(dataList){

        var categoriesList = this.state.categories

        if (typeof object !== 'undefined' && typeof object.serialNumbers === 'number'){
            categoriesList.push(dataList)
        }

        this.setState({categories: categoriesList})
    }

    handleChoose(data_id){
        console.log(data_id)
        return
        this.getJsonData()
    }

    getJsonData(){
        console.log('getJsnoData')
        var _this = this
        let url = this.props.url

        let response = null

        $.ajax({
            url: url,
            dataType: 'json',
            data: {},
            success: function(data){

                console.log(data)
                _this.setState({categories: data})
            }
        })

    }

    render(){

        var _this = this,

        elementCategoryNode = function(object){
            return  <a  href="javascript:void(0)"
                        className="list-group-item"
                        onClick={() =>  _this.loadCategories(object.serialNumber) }>
                        {object.i18n.name}
                    </a>
        }

        return(
            <div className="col-canvas">
            <ul className="wrapper">
                {this.state.categories.map(function(category,serialNum){
                return <li className="report-column">
                    <header>Chooose the category</header>
                    <div>
                        <div className="list-group list-cust">
                        {category.map(function(categoryElement, i){
                            { categoryElement.serialNumber = serialNum }
                            return elementCategoryNode(categoryElement)
                        })}
                        </div>
                    </div>
                </li>
                })}
            </ul>
            </div>
        )
    }
}
