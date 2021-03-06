var React = require("react");
//React.initializeTouchEvents(true);
require("./style.less");
var PickerColumn = require("./PickerColumn");
var Picker = React.createClass({

propTypes :{
            optionGroups    : React.PropTypes.object,
            valueGroups     : React.PropTypes.object,
            itemHeight      : React.PropTypes.number,
            onChange        : React.PropTypes.func,
            numberico       : React.PropTypes.bool,
            numberstr       : React.PropTypes.string,
            height          : React.PropTypes.number
        },
  getInitialState :function(){
            return {
                icostring : '',
                itemHeight : 36,
                height: 144
            }
        },
  renderInner:function() {

    const highlightStyle = {
      height: this.state.itemHeight,
      marginTop: -(this.state.itemHeight / 2)
    };

    if(this.props.numberico) {
                this.state.icostring = (
                    <div className="numberico " id="numberico" >&#xE800;</div>
                )
            }

    const columnNodes = [];
    for (let name in this.props.optionGroups) {
      columnNodes.push(
        <PickerColumn
          key={name}
          name={name}
          options={this.props.optionGroups[name]}
          value={this.props.valueGroups[name]}
          itemHeight={this.state.itemHeight}
          columnHeight={this.state.height}
          onChange={this.props.onChange} />
      );
    }
    return (
      <div className="picker-inner">
        {columnNodes}
        <div className="picker-highlight yo-ico" style={highlightStyle}>  </div>
        <div className=" picker-highlightnum yo-ico yypf-ico" style={highlightStyle}> {this.state.icostring} </div>

      </div>
    );
  },
  render:function() {
    const style = {
      height: this.state.height
    };

    return (
      <div>
      <div className="picker-container" style={style}>
        {this.renderInner()}
      </div>
      </div>
    );
  }
});
module.exports = Picker;
