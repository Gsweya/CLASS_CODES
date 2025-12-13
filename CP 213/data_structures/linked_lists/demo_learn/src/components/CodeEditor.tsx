import React, { useState } from 'react';

interface Props {
  onExecute: (statement: string) => void;
  onClear: () => void;
  suggestions?: string[];
  disabled?: boolean;
}

const CodeEditor: React.FC<Props> = ({ onExecute, onClear, suggestions = [], disabled = false }) => {
  const [input, setInput] = useState('');
  const [history, setHistory] = useState<string[]>([]);

  const commonStatements = [
    'p = head',
    'p = head->link',
    'p = NULL',
    'newNode = createNode(0)',
    'newNode->link = p->link',
    'p->link = newNode',
    'head = newNode',
    'delete p',
  ];

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!input.trim() || disabled) return;
    
    setHistory(prev => [...prev, input.trim()]);
    onExecute(input.trim());
    setInput('');
  };

  const handleSuggestionClick = (suggestion: string) => {
    setInput(suggestion);
  };

  return (
    <div style={{ 
      background: 'white', 
      padding: '20px', 
      borderRadius: '8px', 
      boxShadow: '0 2px 8px rgba(0,0,0,0.1)',
      margin: '20px 0'
    }}>
      <h3 style={{ marginBottom: '15px', color: '#333' }}>C-Style Code Editor</h3>
      
      <form onSubmit={handleSubmit}>
        <div style={{ display: 'flex', gap: '10px', marginBottom: '15px' }}>
          <input
            type="text"
            value={input}
            onChange={(e) => setInput(e.target.value)}
            placeholder="Enter statement (e.g., p = head->link)"
            style={{
              flex: 1,
              padding: '10px',
              fontSize: '14px',
              border: '2px solid #ddd',
              borderRadius: '4px',
              fontFamily: 'monospace'
            }}
            disabled={disabled}
          />
          <button
            type="submit"
            disabled={disabled || !input.trim()}
            style={{
              padding: '10px 20px',
              background: disabled ? '#ccc' : '#4A90E2',
              color: 'white',
              border: 'none',
              borderRadius: '4px',
              cursor: disabled ? 'not-allowed' : 'pointer',
              fontWeight: 'bold'
            }}
          >
            Execute
          </button>
          <button
            type="button"
            onClick={onClear}
            disabled={disabled}
            style={{
              padding: '10px 20px',
              background: disabled ? '#ccc' : '#e74c3c',
              color: 'white',
              border: 'none',
              borderRadius: '4px',
              cursor: disabled ? 'not-allowed' : 'pointer',
              fontWeight: 'bold'
            }}
          >
            Clear
          </button>
        </div>
      </form>

      {commonStatements.length > 0 && (
        <div style={{ marginBottom: '15px' }}>
          <div style={{ fontSize: '12px', color: '#666', marginBottom: '8px' }}>
            Quick statements:
          </div>
          <div style={{ display: 'flex', flexWrap: 'wrap', gap: '8px' }}>
            {commonStatements.map((stmt, idx) => (
              <button
                key={idx}
                onClick={() => handleSuggestionClick(stmt)}
                disabled={disabled}
                style={{
                  padding: '6px 12px',
                  background: disabled ? '#f0f0f0' : '#f8f9fa',
                  border: '1px solid #ddd',
                  borderRadius: '4px',
                  cursor: disabled ? 'not-allowed' : 'pointer',
                  fontSize: '12px',
                  fontFamily: 'monospace'
                }}
              >
                {stmt}
              </button>
            ))}
          </div>
        </div>
      )}

      {history.length > 0 && (
        <div>
          <div style={{ fontSize: '12px', color: '#666', marginBottom: '8px' }}>
            Execution history:
          </div>
          <div style={{ 
            maxHeight: '150px', 
            overflowY: 'auto',
            background: '#f8f9fa',
            padding: '10px',
            borderRadius: '4px',
            fontFamily: 'monospace',
            fontSize: '12px'
          }}>
            {history.slice(-10).reverse().map((stmt, idx) => (
              <div key={idx} style={{ marginBottom: '4px', color: '#555' }}>
                {history.length - idx}. {stmt}
              </div>
            ))}
          </div>
        </div>
      )}
    </div>
  );
};

export default CodeEditor;


