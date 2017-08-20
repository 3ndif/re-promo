import DropzoneComponent from 'react-dropzone-component';
import ReactDOMServer from 'react-dom/server';

export default class MyDropzone extends React.Component {

    state = {
    }

    static defaultProps = {
        postUrl: '',
        dir: '',
        iconFiletypes: ['.jpg', '.png', '.jpeg']
//        dropzoneSelector: 'div.dropzone-component'
    }

    // #https://habrahabr.ru/post/319358/
    static propTypes = {
//      postUrl: React.PropTypes.oneOf(['News', 'Photos']),
        postUrl: React.PropTypes.string.isRequired
    }

    constructor(props) {
        super(props);
        console.log(props)
    }

    handleClick() {
        console.log(this.state);
    }

    sayHello() {
        this.setState({
            message: 'hello'
        });
    }

    componentDidMount() {
        console.log('findDOMNode')
        console.log(ReactDOM.findDOMNode(this))
    }

    render() {
        var $Dropzone = this;

        var djsConfig = {
            previewTemplate: ReactDOMServer.renderToStaticMarkup(
              <div className="dz-preview dz-file-preview">
                <div className="dz-details">
                  <img data-dz-thumbnail="true" />
                </div>
                <div className="dz-error-message">
                    <span data-dz-errormessage="true"></span>
                </div>
                <div><img className="dz-remove" src="img/icons/car.png" alt="Click me to remove the file." data-dz-remove /></div>
              </div>
            ),
            dictDefaultMessage: 'Загрузите изображения',
            maxFilesize: 2,
            maxFiles:1,
            acceptedFiles: 'image/*',
            dictInvalidFileType: 'Допускаются только .png, .jpg .jpeg',
            dictMaxFilesExceeded: "You can only upload upto 5 images",
//            addRemoveLinks: true,
            dictRemoveFile: "Delete",
            dictCancelUploadConfirmation: "Are you sure to cancel upload?",
            dictRemoveFileConfirmation: "Are you sure?",
            init: function () {
                    var thisDropzone = this;
                    $.get($Dropzone.props.postUrl, function(data) {
                        $.each(data, function(k,image){
                            var img = image.data;
                            var mockFile = { name: img.name, type: img.type, size: img.size };

                            this.options.addedfile.call(this, mockFile);
                            this.options.thumbnail.call(this, mockFile, $Dropzone.props.dir+"/"+img.name);
                            this.files.push(mockFile);

                        }.bind(this))

                        console.log(this.files)
                    }.bind(this));
              }
        };

        var eventHandlers = {
            complete: (file) => console.log(file),
            success: function(file,response){
                console.log('response')
//                console.log(file)
//                console.log(response)
            },
            addedfile: function(file){
                console.log('addfile')
                console.log(file);
                console.log(this.files)
                if (this.files[1] != null){
                    this.removeFile(this.files[0]);
                }
            },
            removedfile: function(file){
                console.log('removefile')
//                console.log(file);
            }

        };

        return (
                <div>
                <DropzoneComponent config={this.props} djsConfig={djsConfig} eventHandlers={eventHandlers}>
                        <div class="dz-message btn btn-default"><span>Загрузить</span></div>
                </DropzoneComponent>
                </div>
        );
    }
}