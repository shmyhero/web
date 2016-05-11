var React = require("react");
React.initializeTouchEvents(true);

var PickerColumn = React.createClass({
  propTypes :{
            options         : React.PropTypes.array,
            value           : React.PropTypes.any,                 
            name            : React.PropTypes.string,  
            itemHeight       : React.PropTypes.number,                        
            onChange        : React.PropTypes.func,                             
            columnHeight     : React.PropTypes.number                             
        },
  getInitialState :function(){
            return {
                 isMoving: false,
                 startTouchY: 0,
                 startScrollerTranslate: 0
            }
        },
  componentWillMount  :function(){
      this.setState(this.computeTranslate(this.props));
  },
  componentWillReceiveProps:function(nextProps) {
    if (this.state.isMoving) {
      return;
    }
    this.setState(this.computeTranslate(nextProps));
  },
  computeTranslate :function (props) {
    //console.log(props);
    let selectedIndex = props.options.indexOf(props.value);
    //console.log(selectedIndex);
    if (selectedIndex < 0) {
      this.onValueSelected(props.options[0]);
      selectedIndex = 0;
    }
    return {
      scrollerTranslate: props.columnHeight / 2 - props.itemHeight / 2 - selectedIndex * props.itemHeight,
      minTranslate: props.columnHeight / 2 - props.itemHeight * props.options.length + props.itemHeight / 2,
      maxTranslate: props.columnHeight / 2 - props.itemHeight / 2
    };
  },
  onValueSelected :function(newValue)  {
    this.props.onChange(this.props.name, newValue);
  },

  handleTouchStart :function (event)  {
    const startTouchY = event.targetTouches[0].pageY;
    this.setState(({scrollerTranslate}) => ({
      startTouchY,
      startScrollerTranslate: scrollerTranslate
    }));
  },

  handleTouchMove :function (event)  {
    event.preventDefault();
    const touchY = event.targetTouches[0].pageY;
    this.setState(({isMoving, startTouchY, startScrollerTranslate, minTranslate, maxTranslate}) => {
      if (!isMoving) {
        return {
          isMoving: true
        }
      }

      let nextScrollerTranslate = startScrollerTranslate + touchY - startTouchY;
      if (nextScrollerTranslate < minTranslate) {
        nextScrollerTranslate = minTranslate - Math.pow(minTranslate - nextScrollerTranslate, 0.8);
      } else if (nextScrollerTranslate > maxTranslate) {
        nextScrollerTranslate = maxTranslate + Math.pow(nextScrollerTranslate - maxTranslate, 0.8);
      }
      return {
        scrollerTranslate: nextScrollerTranslate
      };
    });
  },

  handleTouchEnd :function (event) {
    if (!this.state.isMoving) {
      return;
    }
    this.setState({
      isMoving: false,
      startTouchY: 0,
      startScrollerTranslate: 0
    });
    setTimeout(() => {
      const {options, itemHeight} = this.props;
      const {scrollerTranslate, minTranslate, maxTranslate} = this.state;
      let activeIndex;
      if (scrollerTranslate > maxTranslate) {
        activeIndex = 0;
      } else if (scrollerTranslate < minTranslate) {
        activeIndex = options.length - 1;
      } else {
        activeIndex = - Math.floor((scrollerTranslate - maxTranslate) / itemHeight);
      }
      this.onValueSelected(options[activeIndex]);
    }, 0);
  },

  handleTouchCancel :function (event)  {
    if (!this.state.isMoving) {
      return;
    }
    this.setState((startScrollerTranslate) => ({
      isMoving: false,
      startTouchY: 0,
      startScrollerTranslate: 0,
      scrollerTranslate: startScrollerTranslate
    }));
  },

  handleItemClick :function (option) {
    if (option !== this.props.value) {
      this.onValueSelected(option);
    }
  },
  renderItems:function() {

    return this.props.options.map((option, index) => {
      const style = {
        
        height: this.props.itemHeight + 'px',
        lineHeight: this.props.itemHeight + 'px'
      };
      const className = `picker-item${option === this.props.value ? ' picker-item-selected' : ''}`;
      return (
        <div
          key={index}
          className={className}
          style={style}
          onClick={() => this.handleItemClick(option)}>{option}</div>
      );
    });
  },
  render : function () {
    const translateString = `translate3d(0, ${this.state.scrollerTranslate}px, 0)`;
    const style = {
      MsTransform: translateString,
      MozTransform: translateString,
      OTransform: translateString,
      WebkitTransform: translateString,
      transform: translateString
    };
    if (this.state.isMoving) {
      style.transitionDuration = '0ms';
    }
    return(
      <div className="picker-column">
        <div
          className="picker-scroller"
          style={style}
          onTouchStart={this.handleTouchStart}
          onTouchMove={this.handleTouchMove}
          onTouchEnd={this.handleTouchEnd}
          onTouchCancel={this.handleTouchCancel}>
          {this.renderItems()}
        </div>
      </div>
    )
  }
});
module.exports =  PickerColumn;