import { Suspense, lazy, ComponentType } from "react";
import LoadingSpinner from "./LoadingSpinner";

interface LazyComponentProps {
  component: () => Promise<{ default: ComponentType<any> }>;
  fallback?: React.ReactNode;
  className?: string;
}

const LazyComponent = ({ 
  component, 
  fallback,
  className = "" 
}: LazyComponentProps) => {
  const LazyLoadedComponent = lazy(component);

  const defaultFallback = (
    <div className={`flex items-center justify-center min-h-[200px] ${className}`}>
      <LoadingSpinner size="lg" text="Loading component..." />
    </div>
  );

  return (
    <Suspense fallback={fallback || defaultFallback}>
      <LazyLoadedComponent />
    </Suspense>
  );
};

export default LazyComponent; 