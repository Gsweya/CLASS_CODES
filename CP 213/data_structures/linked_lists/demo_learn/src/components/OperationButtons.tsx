import React from 'react';

interface Props {
  onCreateList: () => void;
  onInsertBeginning: () => void;
  onInsertEnd: () => void;
  onInsertMiddle: () => void;
  onDelete: () => void;
  onTraverse: () => void;
  onSearch: () => void;
  onDemonstrateWrong: () => void;
  disabled?: boolean;
}

const OperationButtons: React.FC<Props> = ({
  onCreateList,
  onInsertBeginning,
  onInsertEnd,
  onInsertMiddle,
  onDelete,
  onTraverse,
  onSearch,
  onDemonstrateWrong,
  disabled = false
}) => {
  const buttonStyle = {
    padding: '10px 15px',
    margin: '5px',
    background: disabled ? '#ccc' : '#667eea',
    color: 'white',
    border: 'none',
    borderRadius: '6px',
    cursor: disabled ? 'not-allowed' : 'pointer',
    fontWeight: 'bold',
    fontSize: '13px',
    transition: 'all 0.2s'
  };

  return (
    <div style={{
      background: 'white',
      padding: '20px',
      borderRadius: '8px',
      boxShadow: '0 2px 8px rgba(0,0,0,0.1)',
      margin: '20px 0'
    }}>
      <h3 style={{ marginBottom: '15px', color: '#333' }}>Quick Operations</h3>
      <div style={{ display: 'flex', flexWrap: 'wrap', gap: '10px' }}>
        <button onClick={onCreateList} disabled={disabled} style={buttonStyle}>
          Create List
        </button>
        <button onClick={onInsertBeginning} disabled={disabled} style={buttonStyle}>
          Insert at Beginning
        </button>
        <button onClick={onInsertEnd} disabled={disabled} style={buttonStyle}>
          Insert at End
        </button>
        <button onClick={onInsertMiddle} disabled={disabled} style={buttonStyle}>
          Insert in Middle
        </button>
        <button onClick={onDelete} disabled={disabled} style={buttonStyle}>
          Delete Node
        </button>
        <button onClick={onTraverse} disabled={disabled} style={buttonStyle}>
          Traverse
        </button>
        <button onClick={onSearch} disabled={disabled} style={buttonStyle}>
          Search
        </button>
        <button 
          onClick={onDemonstrateWrong} 
          disabled={disabled} 
          style={{...buttonStyle, background: disabled ? '#ccc' : '#e74c3c'}}
        >
          Demonstrate Wrong Order
        </button>
      </div>
    </div>
  );
};

export default OperationButtons;


