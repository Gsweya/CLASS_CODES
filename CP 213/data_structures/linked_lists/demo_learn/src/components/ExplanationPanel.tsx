import React from 'react';

interface Props {
  explanation: string;
  error?: string;
  warning?: string;
}

const ExplanationPanel: React.FC<Props> = ({ explanation, error, warning }) => {
  if (!explanation && !error && !warning) {
    return (
      <div style={{
        background: '#f8f9fa',
        padding: '15px',
        borderRadius: '8px',
        margin: '20px 0',
        minHeight: '60px',
        border: '1px solid #ddd'
      }}>
        <div style={{ color: '#666', fontStyle: 'italic' }}>
          Execute a statement to see explanations here...
        </div>
      </div>
    );
  }

  return (
    <div style={{
      background: error ? '#FFE5E5' : warning ? '#FFF4E5' : '#E8F5E9',
      padding: '15px',
      borderRadius: '8px',
      margin: '20px 0',
      border: `2px solid ${error ? '#FF0000' : warning ? '#FFA500' : '#4CAF50'}`
    }}>
      {error && (
        <div style={{ marginBottom: '10px' }}>
          <strong style={{ color: '#FF0000', fontSize: '16px' }}>❌ Error:</strong>
          <div style={{ color: '#C00', marginTop: '5px', fontSize: '14px' }}>
            {error}
          </div>
        </div>
      )}
      {warning && (
        <div style={{ marginBottom: '10px' }}>
          <strong style={{ color: '#FFA500', fontSize: '16px' }}>⚠️ Warning:</strong>
          <div style={{ color: '#B8860B', marginTop: '5px', fontSize: '14px' }}>
            {warning}
          </div>
        </div>
      )}
      {explanation && (
        <div>
          <strong style={{ color: '#2E7D32', fontSize: '16px' }}>💡 Explanation:</strong>
          <div style={{ color: '#1B5E20', marginTop: '5px', fontSize: '14px', lineHeight: '1.6' }}>
            {explanation}
          </div>
        </div>
      )}
    </div>
  );
};

export default ExplanationPanel;


