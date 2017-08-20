import ReactDOMServer from 'react-dom/server';
import extend from 'extend';

let Dropzone = null

export default class ReactDropzone extends React.Component {
    constructor(props){
        super(props)

        this.state = { files: [] }
    }

    static defaultProps = {
        djsConfig: {},
        eventHandlers: {}
    }

    getDjsConfig(){
        let options = null
        let that = this

        const defaults = {
            previewTemplate: ReactDOMServer.renderToStaticMarkup(
              <div className="dz-preview dz-file-preview">
                <div className="dz-details">
                  <img data-dz-thumbnail="true" />
                </div>
                <div className="dz-error-message">
                    <span data-dz-errormessage="true"></span>
                </div>
                <div className="dz-remove" data-dz-remove></div>
              </div>
            ),
            dictDefaultMessage: '<div class="btn btn-default">Загрузить</div>',
            maxFilesize: 1,
            maxFiles:1,
            acceptedFiles: 'image/*',
            dictInvalidFileType: 'Допускаются только .png, .jpg .jpeg',
            dictMaxFilesExceeded: "You can only upload upto 1 images",
            dictRemoveFile: "Delete",
            dictCancelUploadConfirmation: "Are you sure to cancel upload?",
            dictRemoveFileConfirmation: "Are you sure?",
            init: function(){
                console.log('init')
                let those = this
                $.get(that.props.djsConfig.url, function(data) {
                    $.each(data, function(k,image){
                        var img = image.data;
                        var mockfile = { name: img.name, type: img.type, size: img.size };

                        const files = that.state.files || []
                        that.dropzone.emit('addedfile',mockfile)
                        that.dropzone.emit('thumbnail', mockfile,that.props.dir+"/"+img.name)
//                        those.options.addedfile.call(those, mockFile);
//                        those.options.thumbnail.call(those, mockFile, that.props.dir+"/"+img.name);

                        var existingFileCount = 1; // The number of files already uploaded
//                        that.dropzone.options.maxFiles = that.dropzone.options.maxFiles - existingFileCount

                        files.push(mockfile)
                        that.setState({ files: files })
                        console.log(that.state.files)
                    })
                });
            },
            maxfilesexceeded: function(file){
                console.log('maxfilesexceeded')
            }
        }

        if(this.props.djsConfig){
            options = extend(true,{},defaults,this.props.djsConfig)
        } else {
            options = defaults
        }

        return options
    }

    getEventHandlers(){
        let eventHandlers = null
        let that = this

        const defaults = {
            addedfile: (file) => {
                console.log('addFile')
                if (!file) return

                var files = that.state.files || []
                console.log(files.length)
                if (files.length > 0){
                    that.dropzone.removeFile(that.state.files[0])

                    files = []
                    files.push(file)
                    that.setState({files: files})
                }
            }
        }

        if (this.props.eventHandlers){
            eventHandlers = extend(true,{},defaults,this.props.eventHandlers)
        } else {
            eventHandlers = defaults
        }
        console.log(eventHandlers)
        return eventHandlers
    }

    /*
     *
     * Вызывается один раз, только на клиенте (не на сервере), сразу же после того,
     * как происходит инициализация рендеринга. На данном этапе в жизненном цикле компонент имеет представление DOM,
     * к которому вы можете получить доступ с помощью this.getDOMNode().
     *
     * Если вы хотите интегрироваться с другими фреймворками JavaScript,
     * установите таймеры используя setTimeout или setInterval, или отправьте AJAX запросы,
     * выполняйте эти операции в этом методе.
     */
    componentDidMount() {
        console.log('componentDidMount')
        const options = this.getDjsConfig()

        Dropzone = Dropzone || require('dropzone')
        Dropzone.autoDiscover = false

        var dropzoneNode = this.props.dopzoneSelector || ReactDOM.findDOMNode(this)

        this.dropzone = new Dropzone(dropzoneNode, options)
        this.setupEvents()
    }


    /**
     * Вызывается непосредственно перед тем, как компонент демонтируется из DOM.
     *
     * Выполняйте любую необходимую очистку в этом методе такие как: отключение
     * таймеров или очистки любых DOM элементов, которые были созданы в componentDidMount.
     */
    componentWillUnmount(){
        console.log('componentWillUnmount')
        console.log(this.dropzone.getActiveFiles())

        if (this.dropzone){
            const files = this.dropzone.getActiveFiles()

            if (files.length > 0){
                // Well, seems like we still have stuff uploading.
                // This is dirty, but let's keep trying to get rid
                // of the dropzone until we're done here.
                this.queueDestroy = false

                const destroyInterval = window.setInterval(() => {
                    if (this.queueDestroy === false){
                        return window.clearInterval(destroyInterval)
                    }

                    if (this.dropzone.getActiveFiles().length === 0){
                        this.dropzone = this.destroy(this.dropzone)
                        return window.clearInterval(destroyInterval)
                    }
                }, 500)
            } else {
                this.dropzone = this.destroy(this.dopzone)
            }
        }
    }


    /**
     * Вызывается сразу после возникновения обновление. Этот метод не вызывается для начала рендеринга.
     * Используйте это как возможность работать с DOM, когда компонент уже обновлен.
     */
    componentDidUpdate(){
        console.log('componentDidUpdate')
        const options = this.getDjsConfig()

        this.queueDestroy = false

        if (!this.dropzone){
            var dropzoneNode = this.props.dropzoneSelector || ReactDOM.findDOMNode(this)
            this.dropzone = new Dropzone(dropzoneNode,options)
        }
    }


    /**
     * Вызывается непосредственно перед рендерингом, когда новые свойства или состояние будет получено.
     * Этот метод не вызывается для начала рендеринга.
     * Используйте это как возможность выполнить подготовку перед обновлением.
     *
     * @Примечание:
     * Вы не можете использовать this.setState() в этом методе.
     * Если вам нужно обновить состояние в ответ на изменение свойства,
     * используйте <bold>componentWillReceiveProps</bold>.
     */
    componentWillUpdate(){
        console.log('willUpdate')
        let djsConfigObj

        djsConfigObj = this.props.djsConfig ? this.props.djsConfig : {}
    }

    /**
     * --- RENDER COMPONENT ---
     */
    render(){
        const className = (this.props.className) ? this.props.className + ' dropzone' : 'dropzone'

        return(
            <div className={className}>
                {this.props.children}
                <div className="dz-message"><div className="btn btn-default">Загрузить</div></div>
            </div>
        )
    }

    setupEvents() {
        const eventHandlers = this.getEventHandlers()

        if (!this.dropzone || !eventHandlers) return

        for (var eventHandler in eventHandlers){
            if (eventHandlers.hasOwnProperty(eventHandler) && eventHandlers[eventHandler]){
                // Check if there's an array of event handlers
                if (Object.prototype.toString.call(eventHandlers[eventHandler]) === 'object Array'){
                    for(var i = 0; i < eventHandlers[eventHandler].length; i++){
                        if (eventHandler === 'init'){
                            eventHandlers[eventHandler][i](this.dropzone)
                        } else {
                            this.dropzone.on(eventHandler, eventHandlers[eventHandler][i])
                        }
                    }
                // no array
                } else {
                    if (eventHandler === 'init'){
                        eventHandlers[eventHandler](this.dopzone)
                    } else {
                        this.dropzone.on(eventHandler, eventHandlers[eventHandler])
                    }
                }
            }
        }

//        this.dropzone.on('addedfile', (file) => {
//            if (!file) return
//
//            const files = this.state.files || []
//
//            files.push(file)
//            this.setState({ files })
//        })

        this.dropzone.on('removedfile', (file) => {
            if (!file) return

            const files = this.state.files || []
            files.forEach((fileInFiles) => {
              if (fileInFiles.name === file.name && fileInFiles.size === file.size) {
                files.splice(i, 1)
              }
            })

            this.setState({ files })
        })
    }

    destroy(dropzone) {
        dropzone.off()
        return dropzone.destroy()
    }
}
